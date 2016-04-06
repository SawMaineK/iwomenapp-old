<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Input;

use App\Comment;
use App\User;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $validator = Validator::make(Input::all(), [
            'post_id'     => 'required|numeric|exists:comments,post_id',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('post_id'))
                return response()->json($validator->errors()->first('post_id'), 400);
        }
        $count = Comment::where('post_id', Input::get('post_id'))->count();
        return response()->json($count);
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
            'comment'     => 'required|max:255',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('post_id'))
                return response()->json($validator->errors()->first('post_id'), 400);
            if($validator->errors()->has('user_id'))
                return response()->json($validator->errors()->first('user_id'), 400);
            if($validator->errors()->has('comment'))
                return response()->json($validator->errors()->first('comment'), 400);
        }

        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $comments = Comment::with('user')->where('post_id', $id)->get();
        return response()->json($comments);
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
