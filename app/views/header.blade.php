@section ("header")
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand">{{ Config::get('kblis.name') }} {{ Config::get('kblis.version') }}
                    </a>
            </div>

            <div class="grid-3 user-profile">
                @if (Auth::check())
                    <ul class="nav navbar-nav navbar-right dropup">
                        <li class="user-link">
                            <a href="javascript:void(0);">
                                <strong><i>{{ Auth::user()->username }}</i></strong>
                            </a>
                        </li>
                    </ul>
                    <div class="user-settings">
                        <div>
                            <span class="glyphicon glyphicon-edit"></span>
                            <a href='{{ URL::to("user/".Auth::user()->id."/edit") }}'>{{trans('messages.edit-profile')}}</a>

                        </div>
                        <div>
                            <span class="glyphicon glyphicon-log-out"></span>
                            <a href="{{ URL::route("user.logout") }}">{{trans('messages.logout')}}</a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="grid-3 user-profile">
                @if (Auth::check())
                    <ul class="nav navbar-nav navbar-right lab-section-change">
                        <li class="loc-link">
                            <a href="javascript:void(0);" >
                                <strong>Change lab section</strong>
                            </a>
                        </li>
                    </ul>
                    <div class="loc-settings">

                        <?php

                            $user_id = Auth::user()->id;

                            $u_lab_sec = DB::select("SELECT (SELECT name FROM test_categories
                              WHERE id = c.test_category_id) AS name, c.test_category_id FROM user_testcategory c WHERE user_id = $user_id");
                        ?>

                        @foreach($u_lab_sec as $val)
                                <div>
                                    <span class="glyphicon glyphicon-log-out"></span>
                                    <a href="/user/change_location/{{$val->test_category_id}}">{{$val->name}}</a>
                                </div>
                        @endforeach

                    </div>
                @endif
            </div>

            <div class="pull-right">

                <ul class="nav navbar-nav navbar-right">
                    <li >
                        <span class="navbar-brand lab-section-banner">{{ TestCategory::find(Session::get('location_id'))->name }}</span>
                    </li>
                </ul>

            </div>

        </div>
    </div>
@show