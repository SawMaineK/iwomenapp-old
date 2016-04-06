<?php

namespace App\Http\Controllers;
use Sentinel;
use View;
use URL;
use \Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use \Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Reminder;
use Mail;
use Validator;
use Activation;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\GroupUser;

class UserController extends Controller
{

    public function postLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email'     => 'email',
            'phone'     => 'numeric',
            'password'  => 'required|between:3,32',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('email'))
                return response()->json($validator->errors()->first('email'), 400);
            if($validator->errors()->has('phone'))
                return response()->json($validator->errors()->first('phone'), 400);
            if($validator->errors()->has('password'))
                return response()->json($validator->errors()->first('password'), 400);
        }
        $credentials_by = 'email';
        if ($request->email) {
            $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
            ];
            $credentials_by = 'email';
        }elseif ($request->username) {
            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
            ];
            $credentials_by = 'username';
        }elseif ($request->phone) {
            $credentials = [
                'phone' => $request->phone,
                'password' => $request->password,
            ];
            $credentials_by = 'phone';
        }else{
            return response()->json('Required any email or username or phone.', 400);
        }

        try {
            $user = Sentinel::authenticate($credentials, false);
            if($user)
            {
                $user = Sentinel::login($user);
                $user->roles = $user->getRoles();
                return response()->json($user);
            }
 
            return response()->json('Invalid '.$credentials_by.' and password.', 400);
 
        } catch (NotActivatedException $e) {
            return response()->json('Your account has not been activated yet.', 400);
        } catch (ThrottlingException $e) {
            return response()->json('Your email was suspended.', 400);
        }
        return response()->json('Invalid email and password.', 400);   
    }

    public function getLogout(){

    }

    public function getRegister(){
        return response()->json(csrf_token());
    }

    public function postRegister(Request $request){
        $roles = [
                    'username'  => 'unique:users,username',
                    'email'     => 'email|max:255|unique:users,email',
                    'password'  => 'required|min:6',
                    'phone'     => 'required|min:8|unique:users,phone',
                    'role'      => 'required|exists:roles,name',
                    'group_id'  => 'required',
                ];

        if(!$request->username){
            unset($roles['username']);
        }

        if(!$request->email){
            unset($roles['email']);
        }

        $validator = Validator::make($request->all(), $roles);

        if ($validator->fails()) {
            if($validator->errors()->has('username'))
                return response()->json($validator->errors()->first('username'), 400);
            if($validator->errors()->has('email'))
                return response()->json($validator->errors()->first('email'), 400);
            if($validator->errors()->has('password'))
                return response()->json($validator->errors()->first('password'), 400);
            if($validator->errors()->has('phone'))
                return response()->json($validator->errors()->first('phone'), 400);
            if($validator->errors()->has('role'))
                return response()->json($validator->errors()->first('role'), 400);
            if($validator->errors()->has('role'))
                return response()->json($validator->errors()->first('group_id'), 400);
        }
        
        $credentials = [
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'photo' => $request->photo,
        ];

        if($request->email){

            $user = Sentinel::register($credentials);

            //un-comment below code incase if user have to activate manually

            // Data to be used on the email view
            $data = array(
                'user'          => $user,
                'activationUrl' => 'http://api.shopyface.com/api-v1/activate/'.$user->id.'?access_token='.$request->access_token,
            );

            // Send the activation code through email
            Mail::send('emails.register-activate', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Welcome ' . $user->first_name);
            });

        }else{
            $user = Sentinel::register($credentials,true);
        }

        $role = Sentinel::findRoleByName($request->role);

        if($role)
            $role->users()->attach($user);     

        $group_user = new GroupUser();
        $group_user->group_id = $request->group_id;
        $group_user->user_id = $user->id;
        $group_user->save();

        return response()->json($user);
    }

    /**
     * User update form processing page.
     *
     * @param  int      $id
     * @return Response
     */
    public function postEdit(Request $request,$id = null)
    {
        try {
            // Get the user information
            $user = Sentinel::findById($id);
            if(!$user){
                return response()->json('You have not in database.', 400);
            }
        } catch (UserNotFoundException $e) {
            return response()->json('You have not in database.', 400);
        }

        if(isset($user->username) && $request->username){
            $role['username'] = "unique:users,username,{$user->username},username";
        }

        if(isset($user->email) && $request->email){
            $role['email'] = "email|unique:users,email,{$user->email},email";
        }

        if ($request->password) {
            $role['password']  = "required|min:6";
        }

        if (isset($user->phone) && $request->phone) {
            $role['phone']     = "required|min:8|unique:users,phone,{$user->phone},phone";
        }

        $validator = Validator::make($request->all(), $role);

        if ($validator->fails()) {
            if($validator->errors()->has('username'))
                return response()->json($validator->errors()->first('username'), 400);
            if($validator->errors()->has('email'))
                return response()->json($validator->errors()->first('email'), 400);
            if($validator->errors()->has('password'))
                return response()->json($validator->errors()->first('password'), 400);
            if($validator->errors()->has('phone'))
                return response()->json($validator->errors()->first('phone'), 400);
        }

        try {
            
            $user->username     = $request->username ? $request->username : $user->username;
            $user->email        = $request->email ? $request->email : $user->email;
            $user->first_name   = $request->first_name ? $request->first_name : $user->first_name;
            $user->last_name    = $request->last_name ? $request->last_name : $user->last_name;
            $user->phone        = $request->phone ? $request->phone : $user->phone;
            $user->address      = $request->address ? $request->address : $user->address;
            $user->photo        = $request->photo ? $request->photo : $user->photo;

            // Do we want to update the user password?
            if ($request->password) {
                $user->password = $password;
            }

            // Was the user updated?
            if ($user->save()) {
                return response()->json($user);
            }

            return response()->json('Sothing went wrong.', 400);
        } catch (LoginRequiredException $e) {
            return response()->json('You must be first login.', 400);
        }

        return response()->json('Sothing went wrong.', 400);
    }

    public function postUpload(Request $request){
        $validator = Validator::make($request->all(), [
            'image'     => 'mimes:jpg,jpeg,bmp,png|max:10000',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('image')){
                return response()->json($validator->errors()->first('image'), 400);
            }
        }
        $photo = $this->upload($request->file('image'), '/users_photo/');
        return response()->json($photo);

    }

    

    public function postRole(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:255|unique:roles',
            'slug'      => 'required',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('name'))
                return response()->json($validator->errors()->first('name'), 400);
            if($validator->errors()->has('slug'))
                return response()->json($validator->errors()->first('slug'), 400);
        }

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json($role);
    }

    public function postPermission(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required|exists:roles,name',
            'permission'=> 'required',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('name'))
                return response()->json($validator->errors()->first('name'), 400);
            if($validator->errors()->has('permission'))
                return response()->json($validator->errors()->first('permission'), 400);
        }

        $permissions = json_decode($request->permission, true);
        if(!$permissions && !is_array($permissions))
            return response()->json('Invalid permission data format.', 400);


        $role = Sentinel::findRoleByName($request->name);

        $role->permissions = $permissions;

        $role->save();

        return response()->json($role);
    }

    /**
     * User account activation page.
     *
     * @param number $userId
     * @param string $activationCode
     * @return
     */
    public function getActivate($userId)
    {
        $user = Sentinel::findById($userId);

        $activation = Activation::create($user);

        if (Activation::complete($user, $activation->code))
        {
            // Activation was successful
            return response()->json('Activation was successful.');
        }
        else
        {
            return response()->json('Activation not found or not completed.');
        }

    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param number $userId
     * @param  string $passwordResetCode
     * @return View
     */
    public function getForgotPasswordConfirm($userId,$passwordResetCode = null)
    {
        // Find the user using the password reset code
        if(!$user = Sentinel::findById($userId))
        {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', Lang::get('auth/message.account_not_found'));
        }

        // Show the page
        return View('admin.auth.forgot-password-confirm');
    }


    /**
     * Forgot password form processing page.
     *
     * @return Redirect
     */
    public function postForgotPassword(Request $request)
    {
        // Declare the rules for the validator
        $rules = array(
            'email' => 'required|email',
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            if($validator->errors()->has('email'))
                return response()->json($validator->errors()->first('email'), 400);
        }

        // Get the user password recovery code
        $user = Sentinel::findByCredentials(['email' => $request->email] );

        if($user)
        {
            //get reminder for user
            $reminder = Reminder::exists($user) ?: Reminder::create($user);

            // Data to be used on the email view
            $data = array(
                'user'              => $user,
                'forgotPasswordUrl' => URL::route('forgot-password-confirm',[$user->id, $reminder->code]),
            );

            // Send the activation code through email
            Mail::send('emails.forgot-password', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Account Password Recovery');
            });
        }
        else
        {
            // Even though the email was not found, we will pretend
            // we have sent the password reset code through email,
            // this is a security measure against hackers.
        }

        return response()->json('We are already sent email to you, please check your email.');

    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param number $userId
     * @param  string   $passwordResetCode
     * @return Redirect
     */
    public function postForgotPasswordConfirm(Request $request,$userId, $passwordResetCode = null)
    {
        // Declare the rules for the form validation
        $rules = array(
            'password'         => 'required|between:3,32',
            'password_confirm' => 'required|same:password'
        );

        // Create a new validator instance from our dynamic rules
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            if($validator->errors()->has('password'))
                return response()->json($validator->errors()->first('password'), 400);
            if($validator->errors()->has('password_confirm'))
                return response()->json($validator->errors()->first('password_confirm'), 400);
        }

        // Find the user using the password reset code
        $user = Sentinel::findById($userId);
        if(!$reminder = Reminder::complete($user, $passwordResetCode,$request->password))
        {
            // Ooops.. something went wrong
            return response()->json('Ooops.. something went wrong', 400);
        }

        // Password successfully reseted
        return response()->json('Password successfully reseted.');
    }
}
