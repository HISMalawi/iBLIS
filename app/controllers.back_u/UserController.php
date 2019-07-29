<?php

use Illuminate\Support\MessageBag;

/**
 *Contains functions for managing users 
 *
 */
class UserController extends Controller {
    
    //Function for user authentication logic
    public function loginAction(){

        if (Input::server("REQUEST_METHOD") == "POST") 
        {
            $validator = Validator::make(Input::all(), array(
                "username" => "required|min:4",
                "password" => "required|min:6",
                "lab_section" => "required"
            ));

            $username = Input::get("username");
            $test_category_id = Input::get("lab_section");

            $message = trans('messages.invalid-login');


                if ($validator->passes()) {
                    $credentials = array(
                        "username" => Input::get("username"),
                        "password" => Input::get("password")
                    );
                    if (Input::get("lab_section")) {

                        $lab_sections = DB::select("SELECT * FROM user_testcategory cc
                                INNER JOIN users u ON cc.user_id = u.id
                                WHERE u.username = '$username' AND cc.test_category_id = $test_category_id");

                        if (COUNT($lab_sections) > 0) {
                            if (Auth::attempt($credentials)) {
                                Session::set("location_id", Input::get("lab_section"));
                                return Redirect::route("user.home");
                            }
                        }else{
                            $message = trans('messages.invalid-location');
                        }
                    }else{
                        $message = trans('messages.empty-location');
                    }

                }


            return Redirect::route('user.login')->withInput(Input::except('password'))
                ->withErrors($validator)
                ->with('message', $message);
        }
        $test_categories = TestCategory::lists("name", "id");
        return View::make("user.login")->with('test_categories', $test_categories);
    }

    public function logoutAction(){
        Auth::logout();
        Session::forget("location_id");
        return Redirect::route("user.login");
    }

    public function change_location($id){
        Session::set("location_id", $id);
        return Redirect::back();
    }

    public function homeAction(){
        return View::make("user.home");
    }


    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        // List all the active users
            $users = User::orderBy('name', 'ASC')->get();

        // Load the view and pass the users
        return View::make('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create User
        $testcategories = TestCategory::orderBy('name', 'ASC')->get();
        return View::make('user.create')->with('testcategories', $testcategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
        $rules = array(
            'username' => 'alpha_num|required|unique:users,username|min:6',
            'password' => 'confirmed|required|min:6',
            'full_name' => 'required',
            'email' => 'required|email'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::route('user.create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $user = new User;
            $user->username = Input::get('username');
            $user->name = Input::get('full_name');
            $user->gender = Input::get('gender');
            $user->designation = Input::get('designation');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));

            $user->save();
            $id = $user->id;

            if (Input::hasFile('image')) {
                try {
                    $extension = Input::file('image')->getClientOriginalExtension();
                    $destination = public_path().'/i/users/';
                    $filename = "user-$id.$extension";

                    $file = Input::file('image')->move($destination, $filename);
                    $user->image = "/i/users/$filename";

                } catch (Exception $e) {}
            }

            $user_testcategories = Input::get("testcategories");

            if ($user_testcategories) {
                foreach ($user_testcategories AS $value) {

                    $user_testcategory = array(
                        'user_id' => $id,
                        'test_category_id' => $value
                    );

                    DB::table('user_testcategory')->insert($user_testcategory);

                }
            }

            try{
                $user->save();
                return Redirect::route('user.index')->with('message', trans('messages.success-creating-user'));
            }catch(QueryException $e){
                Log::error($e);
                return Redirect::route('user.index')
                    ->with('message', trans('messages.failure-creating-user'));
            }
            
            // redirect
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //Show a user
        $user = User::find($id);

        //Show the view and pass the $user to it
        return View::make('user.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the user
        $user = User::find($id);

        $specimentypes = SpecimenType::orderBy('name')->get();
        $testcategories = TestCategory::orderBy('name', 'ASC')->get();
        $user_testcategories = $user->getLabSections();

        //Open the Edit View and pass to it the $user
        return View::make('user.edit')->with('user', $user)
                        ->with('specimentypes', $specimentypes)
                        ->with('testcategories', $testcategories)
                        ->with('user_testcategories', $user_testcategories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
        $rules = array(
            'full_name'       => 'required',
            'email' => 'required|email',
            'image' => 'image|max:500'
        );

        if (Input::get('reset-password')) {
            $rules['reset-password'] = 'min:6';
        }

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::route('user.edit', array($id))
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // Update
            $user = User::find($id);
            $user->name = Input::get('full_name');
            $user->gender = Input::get('gender');
            $user->designation = Input::get('designation');
            $user->email = Input::get('email');

            if (Input::hasFile('image')) {
                try {
                    $extension = Input::file('image')->getClientOriginalExtension();
                    $destination = public_path().'/i/users/';
                    $filename = "user-$id.$extension";

                    $file = Input::file('image')->move($destination, $filename);
                    $user->image = "/i/users/$filename";

                } catch (Exception $e) {
                    Log::error($e);
                }
            }
            
            //Resetting passwords - by the administrator
            if (Input::get('reset-password')) {
                $user->password = Hash::make(Input::get('reset-password'));
            }

            $user->save();

            //update user lab sections

            DB::table('user_testcategory')->where('user_id', '=', $id)->delete();

            $user_testcategories = Input::get("testcategories");

            if ($user_testcategories) {
                foreach ($user_testcategories AS $value) {

                    $user_testcategory = array(
                        'user_id' => $id,
                        'test_category_id' => $value
                    );

                    DB::table('user_testcategory')->insert($user_testcategory);

                }
            }

            // redirect
            $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)->with('message', trans('messages.user-profile-edit-success')) ->with('activeuser', $user ->id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateOwnPassword($id)
    {
        //
        $rules = array(
            'current_password' => 'required|min:6',
            'new_password'  => 'confirmed|required|min:6',
        );

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::route('user.edit', array($id))->withErrors($validator);
        } else {
            // Update
            $user = User::find($id);
            // change password if parameters were entered (changing ones own password)
            if (Hash::check(Input::get('current_password'), $user->password))
            {
                $user->password = Hash::make(Input::get('new_password'));
            }else{
                return Redirect::route('user.edit', array($id))
                        ->withErrors(trans('messages.incorrect-current-passord'));
            }

            $user->save();
        }

        // redirect
        $url = Session::get('SOURCE_URL');
            
        return Redirect::to($url)->with('message', trans('messages.user-profile-edit-success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage (soft delete).
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        //Soft delete the user
        $user = User::find($id);

        $user->delete();

        // redirect
        $url = Session::get('SOURCE_URL');
            
        return Redirect::to($url)->with('message', trans('messages.success-deleting-user'));
    }

    public function labsections(){

        $user = $me;
    }
}
