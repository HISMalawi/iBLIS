@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
		  <li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
		  <li class="active">{{ trans('messages.edit') }}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
            <div class="container-fluid">
	            <div class="row less-gutter">
		            <div class="col-md-11">
						<span class="glyphicon glyphicon-filter"></span>{{ trans('messages.edit') }}
                        @if($test->testType->instruments->count() > 0)
                        <div class="panel-btn">
                            <a class="btn btn-sm btn-info fetch-test-data" href="javascript:void(0)"
                                title="{{trans('messages.fetch-test-data-title')}}"
                                data-test-type-id="{{$test->testType->id}}"
                                data-url="{{URL::route('instrument.getResult')}}"
                                data-instrument-count="{{$test->testType->instruments->count()}}">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                                {{trans('messages.fetch-test-data')}}
                            </a>
                        </div>
                        @endif
                        @if($test->isCompleted() && $test->specimen->isAccepted())
						<div class="panel-btn">
							@if(Auth::user()->can('verify_test_results') && Auth::user()->id != $test->tested_by)
							<a class="btn btn-sm btn-success" href="{{ URL::route('test.verify', array($test->id)) }}">
								<span class="glyphicon glyphicon-thumbs-up"></span>
								{{trans('messages.verify')}}
							</a>
							@endif
							@if(Auth::user()->can('view_reports'))
								<a class="btn btn-sm btn-default" href="{{ URL::to('patientreport/'.$test->visit->patient->id) }}">
									<span class="glyphicon glyphicon-eye-open"></span>
									{{trans('messages.view-report')}}
								</a>
							@endif
						</div>
						@endif
					</div>
		            <div class="col-md-1">
		                <a class="btn btn-sm btn-primary pull-right" href="#" onclick="window.history.back();return false;"
		                    alt="{{trans('messages.back')}}" title="{{trans('messages.back')}}">
		                    <span class="glyphicon glyphicon-backward"></span></a>
		            </div>
		        </div>
		    </div>
		</div>
		<div class="panel-body">
		<!-- if there are creation errors, they will show here -->
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
			<div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
					{{ Form::open(array('route' => array('test.saveResults', $test->id), 'method' => 'POST')) }}
						@foreach($test->testType->measures as $measure)
							<div class="form-group">
								<?php
								$ans = "";
								foreach ($test->testResults as $res) {
									if($res->measure_id == $measure->id)$ans = $res->result;
								}
								 ?>
							<?php
							$fieldName = "m_".$measure->id;
							?>
								@if ( $measure->isNumeric() ) 
			                        {{ Form::label($fieldName , $measure->name) }}
			                        {{ Form::text($fieldName, $ans, array(
			                            'class' => 'form-control result-interpretation-trigger',
			                            'data-url' => URL::route('test.resultinterpretation'),
			                            'data-age' => $test->visit->patient->dob,
			                            'data-gender' => $test->visit->patient->gender,
			                            'data-measureid' => $measure->id
			                            ))
			                        }}
		                            <span class='alert'>

		                            </span>
								@elseif ( $measure->isAlphanumeric() || $measure->isAutocomplete() ) 
			                        <?php
			                        $measure_values = array();
		                            $measure_values[] = '';
			                        foreach ($measure->measureRanges as $range) {
			                            $measure_values[$range->alphanumeric] = $range->alphanumeric;
			                        }
			                        ?>
		                            {{ Form::label($fieldName , $measure->name) }}
		                            {{ Form::select($fieldName, $measure_values, array_search($ans, $measure_values),
		                                array('class' => 'form-control result-interpretation-trigger',
		                                'data-url' => URL::route('test.resultinterpretation'),
										'onchange' => "if(this.value.match(/^Growth$/i)){showCultureOrganisms()}",
		                                'data-measureid' => $measure->id
		                                )) 
		                            }}
								@elseif ( $measure->isFreeText() ) 
		                            {{ Form::label($fieldName, $measure->name) }}
		                            <?php
										$sense = '';
										$datepicker = '';
										if($measure->name=="Sensitivity"||$measure->name=="sensitivity"){
											$sense = ' sense'.$test->id;
										}
										if($measure->name == "Expiry Date"){
											$datepicker = ' datepicker';
										}
									?>
		                            {{Form::text($fieldName, $ans, array('class' => 'form-control'.$sense.$datepicker))}}
								@endif
								{{($measure->unit)}}
		                    </div>
		                @endforeach
		                <div class="form-group">
		                    {{ Form::label('interpretation', trans('messages.remarks')) }}
		                    {{ Form::textarea('interpretation', $test->interpretation, 
		                        array('class' => 'form-control result-interpretation', 'rows' => '2')) }}
		                </div>
		                <div class="form-group actions-row" align="left">
							{{ Form::button('<span class="glyphicon glyphicon-save"></span> '.trans('messages.update-test-results'),
								array('class' => 'btn btn-default', 'onclick' => 'submit()')) }}
						</div>
						{{ Form::close() }}
		                @if(count($test->testType->organisms)>0)
                        <div class="panel panel-success">  <!-- Patient Details -->
	                        <div class="panel-heading">
	                            <h3 class="panel-title">{{trans("messages.culture-worksheet")}}</h3>
	                        </div>
	                        <div class="panel-body">
                                <p><strong>{{trans("messages.culture-work-up")}}</strong></p>
                                <table class="table table-bordered">
                                	<thead>
                                		<tr>
											<th width="15%">{{ trans('messages.date')}}</th>
											<th width="10%">{{ trans('messages.tech-initials')}}</th>
											<th>{{ trans('messages.observations-and-work-up')}}</th>
											<th width="10%"></th>
										</tr>
                                	</thead>
									<tbody id="tbbody_<?php echo $test->id ?>">
										@if(($observations = $test->culture) != null)
											@foreach($observations as $observation)
											<tr>
												<td>{{ Culture::showTimeAgo($observation->created_at) }}</td>
												<td>{{ User::find($observation->user_id)->name }}</td>
												<td>{{ $observation->observation }}</td>
												<td></td>
											</tr>
											@endforeach
											<tr>
												<td>{{ Culture::showTimeAgo(date('Y-m-d H:i:s')) }}</td>
												<td>{{ Auth::user()->name }}</td>
												<td>{{ Form::textarea('observation', '', 
						                        	array('class' => 'form-control result-interpretation', 'rows' => '2', 'id' => 'observation_'.$test->id)) }}
						                        </td>
												<td><a class="btn btn-xs btn-success" href="javascript:void(0)" onclick="saveObservation(<?php echo $test->id; ?>, <?php echo Auth::user()->id; ?>, <?php echo "'".Auth::user()->name."'"; ?>)">
													{{ trans('messages.save') }}</a>
												</td>
											</tr>
										@else
											<tr>
												<td>{{ Culture::showTimeAgo(date('Y-m-d H:i:s')) }}</td>
												<td>{{ Auth::user()->name }}</td>
												<td>{{ Form::textarea('observation', $test->interpretation, 
						                        	array('class' => 'form-control result-interpretation', 'rows' => '2', 'id' => 'observation_'.$test->id)) }}
						                        </td>
												<td><a class="btn btn-xs btn-success" href="javascript:void(0)" onclick="saveObservation(<?php echo $test->id; ?>, <?php echo Auth::user()->id; ?>, <?php echo "'".Auth::user()->name."'"; ?>)">
													{{ trans('messages.save') }}</a>
												</td>
											</tr>
										@endif
									</tbody>
								</table>
								<p><strong>{{trans("messages.susceptibility-test-results")}}</strong></p>
								<div class="form-group">
									<div class="form-pane panel panel-default">
										<div class="container-fluid">
											<?php 
												$cnt = 0;
												$zebra = "";
												$checked=false;
												$checker = '';
												$susOrgIds = array();
												$defaultZone='';
												$defaultInterp='';
											?>
											@foreach($test->testType->organisms as $key=>$value)
												@if(count($test->susceptibility)>0)
													@foreach($test->susceptibility as $drugSusceptibility)
														<?php

														array_push($susOrgIds, $drugSusceptibility->organism_id);
														if(in_array($value->id, $susOrgIds)){
															$checked='checked';
														}
														?>
													@endforeach

												@endif
												{{ ($cnt%4==0)?"<div class='row $zebra'>":"" }}
												<?php
													$cnt++;
													$zebra = (((int)$cnt/4)%2==1?"row-striped":"");
												?>
												<div style="display: {{$checked ? '' : 'none'}}" class="col-md-4" id="organism{{$value->id}}">
													<label  class="checkbox">
														<input  type="checkbox" name="organism[]" value="{{ $value->id}}" {{ $checked }} onchange="javascript:showSusceptibility(<?php echo $value->id; ?>)" />{{$value->name}}
													</label>
												</div>
												{{ ($cnt%4==0)?"</div>":"" }}
												<?php
													$checked=false;
												?>
											@endforeach
										</div>
									</div>
								</div>
								@foreach($test->testType->organisms as $key=>$value)
									@if(count($test->susceptibility)>0)
										@foreach($test->susceptibility as $drugSusceptibility)
											<?php
											array_push($susOrgIds, $drugSusceptibility->organism_id);
											if(in_array($value->id, $susOrgIds))
												$checker='checked';
											?>
										@endforeach
									@endif
									<?php if($checker=='checked'){$display='display:block';}else if($checker!='checked'){$display='display:none';} ?>
								{{ Form::open(array('','id' => 'drugSusceptibilityForm_'.$value->id, 'name' => 'drugSusceptibilityForm_'.$value->id, 'style'=>$display)) }}
								<table class="table table-bordered" id="susc_<?php echo $value->id; ?>">
									<thead>
										<tr>
											<th colspan="3">{{ $value->name }}</th>
										</tr>
										<tr>
											<th width="50%">{{ Lang::choice('messages.drug',1) }}</th>
											<th>{{ trans('messages.zone-size')}}</th>
											<th>{{ trans('messages.interp')}}</th>
										</tr>
									</thead>
									<tbody id="enteredResults_<?php echo $value->id; ?>">
										@foreach($value->drugs as $drug)
										{{ Form::hidden('test[]', $test->id, array('id' => 'test[]', 'name' => 'test[]')) }}
										{{ Form::hidden('drug[]', $drug->id, array('id' => 'drug[]', 'name' => 'drug[]')) }}
										{{ Form::hidden('organism[]', $value->id, array('id' => 'organism[]', 'name' => 'organism[]')) }}
										@if($sensitivity=Susceptibility::getDrugSusceptibility($test->id, $value->id, $drug->id))
											<?php

											$defaultZone = $sensitivity->zone;
											$defaultInterp = $sensitivity->interpretation;
											?>
										@endif
										<tr>
											<td>{{ $drug->name }}</td>
											<td>
												{{ Form::selectRange('zone[]', 0, 50, $defaultZone, ['class' => 'form-control', 'id' => 'zone[]', 'style'=>'width:auto']) }}
											</td>
											<td>{{ Form::select('interpretation[]', array($defaultInterp=>$defaultInterp, 'S' => 'S', 'I' => 'I', 'R' => 'R'),'', ['class' => 'form-control', 'id' => 'interpretation[]', 'style'=>'width:auto']) }}</td>
										</tr>
										@endforeach
										<tr id="submit_drug_susceptibility_<?php echo $value->id; ?>">
											<td colspan="3" align="right">
												<div class="col-sm-2">
													<a class="btn btn-default" href="javascript:void(0)" onclick="addDrugSusceptibility(<?php echo $test->id; ?>, <?php echo $value->id; ?>)">
														{{ trans('messages.insert-drug') }}</a>
												</div>
												<div class="col-sm-offset-6  col-sm-2">
													<a class="btn btn-danger" href="javascript:void(0)" onclick="deleteDrugSusceptibility(<?php echo $test->id; ?>, <?php echo $value->id; ?>)">
														{{ trans('messages.delete') }}</a>
												</div>
												<div class="col-sm-2">
													<a class="btn btn-success" href="javascript:void(0)" onclick="saveDrugSusceptibility(<?php echo $test->id; ?>, <?php echo $value->id; ?>)">
														{{ trans('messages.save') }}</a>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								{{ Form::close() }}
								<?php
									$checker = false;
								?>
								@endforeach
                              </div>
	                        </div> <!-- ./ panel-body -->
	                    </div>
                        @endif
					</div>
	                <div class="col-md-6">
	                    <div class="panel panel-info">  <!-- Patient Details -->
	                        <div class="panel-heading">
	                            <h3 class="panel-title">{{trans("messages.patient-details")}}</h3>
	                        </div>
	                        <div class="panel-body">
	                            <div class="container-fluid">
	                                <div class="row">
	                                    <div class="col-md-3">
	                                        <p><strong>{{trans("messages.patient-number")}}</strong></p></div>
	                                    <div class="col-md-9">
	                                        {{$test->visit->patient->patient_number}}</div></div>
	                                <div class="row">
	                                    <div class="col-md-3">
	                                        <p><strong>{{ Lang::choice('messages.name',1) }}</strong></p></div>
	                                    <div class="col-md-9">
	                                        {{$test->visit->patient->name}}</div></div>
	                                <div class="row">
	                                    <div class="col-md-3">
	                                        <p><strong>{{trans("messages.age")}}</strong></p></div>
	                                    <div class="col-md-9">
	                                        {{$test->visit->patient->getAge()}}</div></div>
	                                <div class="row">
	                                    <div class="col-md-3">
	                                        <p><strong>{{trans("messages.gender")}}</strong></p></div>
	                                    <div class="col-md-9">
	                                        {{$test->visit->patient->gender==0?trans("messages.male"):trans("messages.female")}}
	                                    </div></div>
	                            </div>
	                        </div> <!-- ./ panel-body -->
	                    </div> <!-- ./ panel -->
	                    <div class="panel panel-info"> <!-- Specimen Details -->
	                        <div class="panel-heading">
	                            <h3 class="panel-title">{{trans("messages.specimen-details")}}</h3>
	                        </div>
	                        <div class="panel-body">
	                            <div class="container-fluid">
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{ Lang::choice('messages.specimen-type',1) }}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        {{$test->specimen->specimenType->name or trans('messages.pending') }}
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{trans('messages.specimen-number')}}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        {{$test->specimen->accession_number or trans('messages.pending') }}
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{trans('messages.specimen-status')}}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        {{trans('messages.'.$test->specimen->specimenStatus->name) }}
	                                    </div>
	                                </div>
	                            @if($test->specimen->isRejected())
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{trans('messages.rejection-reason-title')}}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        {{$test->specimen->rejectionReason->reason or trans('messages.pending') }}
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{trans('messages.reject-explained-to')}}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        {{$test->specimen->reject_explained_to or trans('messages.pending') }}
	                                    </div>
	                                </div>
	                            @endif
	                            @if($test->specimen->isReferred())
	                            <br>
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{trans("messages.specimen-referred-label")}}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        @if($test->specimen->referral->status == Referral::REFERRED_IN)
	                                            {{ trans("messages.in") }}
	                                        @elseif($test->specimen->referral->status == Referral::REFERRED_OUT)
	                                            {{ trans("messages.out") }}
	                                        @endif
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{Lang::choice("messages.facility", 1)}}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        {{$test->specimen->referral->facility->name }}
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{trans("messages.person-involved")}}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        {{$test->specimen->referral->person }}
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{trans("messages.contacts")}}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        {{$test->specimen->referral->contacts }}
	                                    </div>
	                                </div>
	                                <div class="row">
	                                    <div class="col-md-4">
	                                        <p><strong>{{trans("messages.referred-by")}}</strong></p>
	                                    </div>
	                                    <div class="col-md-8">
	                                        {{ $test->specimen->referral->user->name }}
	                                    </div>
	                                </div>
	                            @endif
	                            </div>
	                        </div>
	                    </div> <!-- ./ panel -->
	                    <div class="panel panel-info">  <!-- Test Results -->
	                        <div class="panel-heading">
	                            <h3 class="panel-title">{{trans("messages.test-details")}}</h3>
	                        </div>
	                        <div class="panel-body">
	                            <div class="container-fluid">
	                                <div class="display-details">
	                                    <p class="view"><strong>{{ Lang::choice('messages.test-type',1) }}</strong>
	                                        {{ $test->testType->name or trans('messages.unknown') }}</p>
										<p class="view"><strong>{{trans('messages.ward')}}</strong>
											{{$test->visit->ward_or_location or trans('messages.unknown') }}</p>
	                                    <p class="view"><strong>{{trans('messages.date-ordered')}}</strong>
                                            {{ $test->isExternal()?$test->external()->request_date:$test->time_created }}</p>
	                                    <p class="view"><strong>{{trans('messages.lab-receipt-date')}}</strong>
	                                        {{$test->time_created}}</p>
	                                    <p class="view"><strong>{{trans('messages.test-status')}}</strong>
	                                        {{trans('messages.'.$test->testStatus->name)}}</p>
	                                    <p class="view-striped"><strong>{{trans('messages.physician')}}</strong>
	                                        {{$test->requested_by or trans('messages.unknown') }}</p>
	                                    <p class="view-striped"><strong>{{trans('messages.request-origin')}}</strong>
	                                        @if($test->specimen->isReferred() && $test->specimen->referral->status == Referral::REFERRED_IN)
	                                            {{ trans("messages.in") }}
	                                        @else
	                                            {{ $test->visit->visit_type }}
	                                        @endif</p>
	                                    <p class="view-striped"><strong>{{trans('messages.registered-by')}}</strong>
	                                        {{$test->createdBy->name or trans('messages.unknown') }}</p>
	                                    @if($test->isCompleted())
	                                    <p class="view"><strong>{{trans('messages.tested-by')}}</strong>
	                                        {{$test->testedBy->name or trans('messages.unknown')}}</p>
	                                    @endif
	                                    @if($test->isVerified())
	                                    <p class="view"><strong>{{trans('messages.verified-by')}}</strong>
	                                        {{$test->verifiedBy->name or trans('messages.verification-pending')}}</p>
	                                    @endif
	                                    @if((!$test->specimen->isRejected()) && ($test->isCompleted() || $test->isVerified()))
	                                    <!-- Not Rejected and (Verified or Completed)-->
	                                    <p class="view-striped"><strong>{{trans('messages.turnaround-time')}}</strong>
	                                        {{$test->getFormattedTurnaroundTime()}}</p>
	                                    @endif
	                                </div>
	                            </div>
	                        </div> <!-- ./ panel-body -->
	                    </div>  <!-- ./ panel -->
	                </div>
				</div>
			</div>
		</div>

	<!-- Modal -->
	<div id="organismsModel" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Select organisms observed</h4>
				</div>

				<?php
				$cnt = 0;
				$zebra = "";
				$checked=false;
				$checker = '';
				?>

				<div class="modal-body">
					<div class="row" style="padding: 0px;">
						<div class="input-group pull-right" style="width: 250px;margin-top: -65px;margin-right: 45px;">

							<input onkeydown="searchOrganisms(this.innerHTML);" type="text" class="form-control" placeholder="Search for...">
                                  <span class="input-group-btn">
                                    <button class="btn btn-default btn-primary" type="button">Search</button>
                                  </span>
						</div><!-- /input-group -->
					</div>
					<div class="modal-data">
						@foreach($test->testType->organisms as $key=>$value)

							{{ ($cnt%6==0)?"<div class='row $zebra'>":"" }}
							<?php
							$cnt++;
							$zebra = (((int)$cnt/6)%2==1?"row-striped":"");
							?>
							<span class="col-md-2">
                            <label class="checkbox">
								<input class="organism-option" type="checkbox" name="organism-option[]" value="{{ $value->id}}" />{{$value->name}}
							</label>
                        </span>
							{{ ($cnt%6==0)?"</div>":"" }}
						@endforeach
					</div>
				</div>
				<div class="modal-footer">
					<button onclick="displayOrganisms(); hideCultureOrganisms()" type="button" class="btn btn-success">Save</button>
				</div>
			</div>

		</div>
	</div>

@stop