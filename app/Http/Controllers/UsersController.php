<?php

namespace App\Http\Controllers;

use Input;
use Hash;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

use App\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        // return response()->json($users);
        return view('users.list', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$users=User::get();
        foreach ($users as $key => $user) {
            User::where('id',$user->id)->update(array('username'=>$user->first_name.' '.$user->last_name));
        }*/
        // create the validation rules ------------------------
        $rules = array(
            'username'          => 'required|min:3',                        // just a normal required validation
            'email'             => 'email|unique:users',         // required and must be unique in the user table
            'password'          => 'required|min:3|confirmed',
            'password_confirmation'=> 'required|min:3',
            'phone'             => 'min:8'         // required and must be unique in the user table
        );
        // do the validation ----------------------------------
        // validate against the inputs from our form
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return redirect('admin/users/create')->withErrors($validator)->withInput();
        } else {
            $objuser =new User();
            $objuser->username=$request->username;
            $objuser->email=$request->email;
            $objuser->phone=$request->phone;
            $objuser->first_name=$request->username;
            $objuser->password=Hash::make($request->password);
            $objuser->save();
            return redirect('admin/users')->withMessages('Successfully created.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);
        if(!$user){
            return redirect('admin/users')->withWarning('There is no user.');
        }
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // create the validation rules ------------------------
        $rules = array(
            'username'          => 'required|min:3',                        // just a normal required validation
            'email'             => 'email',         // required and must be unique in the user table
            'password'          => 'min:3|confirmed',
            'password_confirmation'=> 'min:3',
            'phone'             => 'min:8'         // required and must be unique in the user table
        );
        // do the validation ----------------------------------
        // validate against the inputs from our form
        $validator = Validator::make(Input::all(), $rules);

        // check if the validator failed -----------------------
        if ($validator->fails()) {
            // get the error messages from the validator
            $messages = $validator->messages();

            // redirect our user back to the form with the errors from the validator
            return redirect('admin/users/create')->withErrors($validator)->withInput();
        } else {
            $objuser =User::find($id);
            if(!$objuser){
                return redirect('admin/users')->withWarning('There is no user');
            }
            $objuser->username=$request->username;
            $objuser->email=$request->email;
            $objuser->phone=$request->phone;
            $objuser->first_name=$request->username;
            if($request->password)
                $objuser->password=Hash::make($request->password);
            $objuser->update();
            return redirect('admin/users')->withMessages('Successfully updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deluser=User::where('id',$id)->delete();
        if(!$deluser){
            return redirect('admin/users')->withWarning('There is no user.');
        }
        return redirect('admin/users')->withMessages('Successfully delete.');
    }
}
