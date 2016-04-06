<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\SeenNotification;

class SeenNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

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
        $validator = Validator::make($request->all(), [
            'user_id'               => 'required',
            'post_notification_id'  => 'required'
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('user_id'))
                return response()->json($validator->errors()->first('user_id'), 400);
            if($validator->errors()->has('post_notification_id'))
                return response()->json($validator->errors()->first('post_notification_id'), 400);
        }

        $seen = SeenNotification::where('user_id', $request->user_id)->where('post_notification_id',$request->post_notification_id)->first();
        if(!$seen){
            $seen = new SeenNotification();
            $seen->user_id = $request->user_id;
            $seen->post_notification_id = $request->post_notification_id;
            $seen->save();
        }
        return response()->json($seen);
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
