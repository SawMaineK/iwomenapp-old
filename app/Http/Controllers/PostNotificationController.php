<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Input;

use App\PostNotification;
use App\SeenNotification;

class PostNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $validator = Validator::make(Input::all(), [
            'user_id'      => 'required',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('user_id'))
                return response()->json($validator->errors()->first('user_id'), 400);
        }

        $post_notification_ids = SeenNotification::where('user_id',Input::get('user_id'))->lists('post_notification_id');

        $notifications = PostNotification::with('user','post')->whereNotIn('id', $post_notification_ids)->get();

        return response()->json($notifications);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        
    }

    public function postUpload(Request $request){
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
