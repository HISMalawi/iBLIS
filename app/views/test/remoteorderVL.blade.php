@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
			<li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
			<li><a href="{{ URL::route('test.index') }}">{{ Lang::choice('messages.test',2) }}</a></li>
			<li class="active">{{trans('messages.test-details')}}</li>
		</ol>
	</div>
	<?php $showWorkSheet = false;?>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<div class="container-fluid">
				<div class="row less-gutter">
					<div class="col-md-11">
						<span class="glyphicon glyphicon-cog"></span>{{trans('messages.test-details')}}
					
						@if(Auth::user()->can('request_test'))
							<div class="panel-btn pull-right">
								<a class="btn btn-sm btn-success"
								   href="{{URL::route('test.mergeorupdate', array($tracking_number))}}"
								   data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Proceed
								</a>
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
		</div> <!-- ./ panel-heading -->
		<div class="panel-body">
			<div class="container-fluid">
				<div class="row">					
					<div class="col-md-offset-2 col-md-8">
						<div class="panel panel-info">  <!-- Patient Details -->
							
							<div class="panel-body">
								<div class="container-fluid">
									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 1:"}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-md-3">
													<p><strong>{{"District:"}}</strong></p>
													</div>
												<div class="col-md-3">
												{{ Form::text('search', Input::get('search'),
													array('class' => 'form-control barcode')) }}
												</div>


												<div class="col-md-3">
													<p><strong>{{"Facility Name:"}}</strong></p>
													</div>
												<div class="col-md-3">
												{{ Form::text('search', Input::get('search'),
													array('class' => 'form-control barcode')) }}
												</div>
											</div>
										</div>
									</div>
									



									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 2:"}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
												<div class="col-md-6">
													<p><strong>{{"Patient Surname:"}}</strong></p>
														{{ Form::text('search', Input::get('search'),
														array('class' => 'form-control barcode')) }}
												</div>
												<div class="col-md-6">
													<p><strong>{{"Patient Firstname:"}}</strong></p>
														{{ Form::text('search', Input::get('search'),
														array('class' => 'form-control barcode')) }}
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
														
													<div class="row">
														<div class="col-md-12">
															<p><strong>{{"Patient ID:"}}</strong></p>
																{{ Form::text('search', Input::get('search'),
																array('class' => 'form-control barcode')) }}
														</div>
													</div>
													<div class="row">
														<div class="col-md-7">
															<p><strong>{{"Patient/Gurdian Phone Number:"}}</strong></p>
																{{ Form::text('search', Input::get('search'),
																array('class' => 'form-control barcode')) }}
														</div>
													</div>


												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">														

															<div class="row">
																<div class="col-md-12">
																	<p><strong>{{"Date of Birth:"}}</strong></p>
																	<input class="form-control" type="date" id="birthday" name="birthday">
																</div>
															</div>
															<div class="row">
																<div class="col-md-12">
																	<p><strong>{{"Date Sample Drawn:"}}</strong></p>
																	<input class="form-control"  type="date" id="birthday" name="birthday">
																</div>
															</div>

														</div>
														<div class="col-md-6">
															<p><strong>{{"Gender/Preg/Bf:"}}</strong></p>
																<label class="container">Male
																	<input type="radio" name="radio" checked>
																	<span class="check"></span>
																</label>
																<label class="container">Female Non-Preg./Bf.
																	<input type="radio" name="radio">
																	<span class="check"></span>
																</label>
																<label class="container">Female Pregnant
																	<input type="radio" name="radio">
																	<span class="check"></span>
																</label>
																<label class="container">Female Breastfeeding
																	<input type="radio" name="radio">
																	<span class="check"></span>
																</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>





									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 3:"}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
													<div class="col-md-6">
														<p><strong>{{"Reason For Testing:"}}</strong></p>
														<select class="form-control" type="date" id="birthday" name="birthday">
															<option> 
																	Routine
															</option>
															<option> 
																	Targeted
															</option>
															<option> 
																	Follow-up after high VL
															</option>
															<option> 
																	Repeat (rejected/lost/missing)
															</option>
														</select>
													</div>												
											</div>
										</div>
									</div>


									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 4:"}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
													<div class="col-md-6">
														<p><strong>{{"ART Initiation Date:"}}</strong></p>
														<input class="form-control"  type="date" id="birthday" name="birthday">
													</div>		
													<div class="col-md-6">
														<p><strong>{{"Sample Type:"}}</strong></p>
														<select class="form-control" type="date" id="birthday" name="birthday">
															<option> 
																	DBS 70ml
															</option>
															<option> 
																	Plasma
															</option>
															<option> 
																	DBS
															</option>
														</select>
													</div>								
											</div>
											<div class="row">															
													<div class="col-md-6">
														<p><strong>{{"Current ART Regimen:"}}</strong></p>
														<select class="form-control" type="date" id="birthday" name="birthday">
															<option> 
																	13A
															</option>
															<option> 
																	15A
															</option>
															<option> 
																	12A
															</option>
														</select>
													</div>								
											</div>
										</div>
									</div>


									<div class="panel panel-info">
										<div class="panel-heading">
											<h1 class="panel-title">{{"Section 6:"}}</h1>
										</div>
										<div class="panel-body">
											<div class="row">
													<div class="col-md-6">
														<p><strong>{{"Sirname:"}}</strong></p>
														{{ Form::text('search', Input::get('search'),
														array('class' => 'form-control barcode')) }}
													</div>		
													<div class="col-md-6">
														<p><strong>{{"First Name:"}}</strong></p>
														{{ Form::text('search', Input::get('search'),
														array('class' => 'form-control barcode')) }}
													</div>								
											</div>
											<div class="row">															
													<div class="col-md-6">
														<p><strong>{{"Phone Number:"}}</strong></p>
														{{ Form::text('search', Input::get('search'),
														array('class' => 'form-control barcode')) }}
													</div>	
													<div class="col-md-4">
														<p><strong>{{"HTC Provider ID:"}}</strong></p>
														{{ Form::text('search', Input::get('search'),
														array('class' => 'form-control barcode')) }}
													</div>								
											</div>
										</div>
									</div>




						

					</div>
				</div>
			</div> <!-- ./ container-fluid -->

		</div> <!-- ./ panel-body -->
	</div> <!-- ./ panel -->

	<div class="panel-info">  <!-- Test Results -->
		
		<div class="panel-body" >
			<div class="container-fluid">
				<div class="row">					
					<div class="col-md-offset-4 col-md-6">
							<div class="panel-btn pull-right ">
								<a class="btn btn-sm btn-danger"
								   href="{{URL::route('test.mergeorupdate', array($tracking_number))}}"
								   data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Cancel
								</a>
							</div>
							<div class="panel-btn pull-right">
								<a class="btn btn-sm btn-danger"
								   href="{{URL::route('test.mergeorupdate', array($tracking_number))}}"
								   data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Reject & Save
								</a>
							</div>
							<div class="panel-btn pull-right">
								<a class="btn btn-sm btn-success"
								   href="{{URL::route('test.mergeorupdate', array($tracking_number))}}"
								   data-toggle="modal" >
									<span class="glyphicon glyphicon-next"></span>
									Accept & Save
								</a>
							</div>								
											
					</div>
				</div>									
			</div>
		</div> <!-- ./ panel-body -->
	</div>  <!-- ./ panel -->

															

@stop