<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors);
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
            'name'     => 'required|unique:authors',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('name'))
                return response()->json($validator->errors()->first('name'), 400);
        }

        $author = new Author();
        $author->name = $request->name;
        $author->about = $request->about;
        $author->about_mm = $request->about_mm;
        $author->image = $request->image;
        $author->save();

        return response()->json($author);


    }

    public function postUpload(Request $request){
        $validator = Validator::make($request->all(), [
            'image'     => 'required|mimes:jpg,jpeg,bmp,png|max:10000',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('image')){
                return response()->json($validator->errors()->first('image'), 400);
            }
        }
        $photo = $this->upload($request->file('image'), '/authors_photo/');
        return response()->json($photo);

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
