<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Like;
use App\User;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
            'post_id'     => 'required|numeric',
            'user_id'     => 'required|numeric',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('post_id'))
                return response()->json($validator->errors()->first('post_id'), 400);
            if($validator->errors()->has('user_id'))
                return response()->json($validator->errors()->first('user_id'), 400);
        }

        $has = Like::where('post_id',$request->post_id)->where('user_id', $request->user_id)->count();
        if($has > 0)
            return response()->json('You has already been taken.', 400);

        $like = new Like();
        $like->user_id = $request->user_id;
        $like->post_id = $request->post_id;
        $like->save();

        return response()->json($like);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $likes = Like::where('post_id', $id)->count();
        return response()->json($likes);
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
    public function destroy(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required|numeric',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('user_id'))
                return response()->json($validator->errors()->first('user_id'), 400);
        }

        $like = Like::where('post_id',$id)->where('user_id', $request->user_id)->delete();

        return response()->json($like);
    }
}
