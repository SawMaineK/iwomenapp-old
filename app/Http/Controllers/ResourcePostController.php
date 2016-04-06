<?php

namespace App\Http\Controllers;

use DB;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\ResourcePost;
use App\ResourcePhoto;
use App\ResourceShare;


class ResourcePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $offset  = Input::get('offset') ? Input::get('offset') : 1;
        $limit   = Input::get('limit') ? Input::get('limit') : 6;

        $offset  = ($offset - 1) * $limit;

        $posts = ResourcePost::with('photos','resource_category','author','user')
                        ->orderBy('created_at','desc')
                                ->offset($offset)->limit($limit)->get();

        
        return response()->json($posts);
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
            'title'                     => 'required|unique:resource_posts,title',
            'title_mm'                  => 'required|unique:resource_posts,title_mm',
            'resource_category_id'      => 'required|numeric',
            'user_id'                   => 'required|numeric',
            'author_id'                 => 'required|numeric',
            'content'                   => 'required',
            'content_mm'                => 'required',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('title'))
                return response()->json($validator->errors()->first('title'), 400);
            if($validator->errors()->has('title_mm'))
                return response()->json($validator->errors()->first('title_mm'), 400);
            if($validator->errors()->has('resource_category_id'))
                return response()->json($validator->errors()->first('resource_category_id'), 400);
            if($validator->errors()->has('user_id'))
                return response()->json($validator->errors()->first('user_id'), 400);
            if($validator->errors()->has('author_id'))
                return response()->json($validator->errors()->first('author_id'), 400);
            if($validator->errors()->has('content'))
                return response()->json($validator->errors()->first('content'), 400);
            if($validator->errors()->has('content_mm'))
                return response()->json($validator->errors()->first('content_mm'), 400);
        }

        
        $photos = null;
        if($request->photos){
            $photos = json_decode($request->photos, true);
            if(!$photos && !is_array($photos)){
                return response()->json('Invalid photos format.', 400);
            }
        }

        try {
            DB::beginTransaction();
            $post = new ResourcePost();
            $post->title        = $request->title;
            $post->title_mm     = $request->title_mm;
            $post->resource_category_id  = $request->resource_category_id;
            $post->author_id    = $request->author_id;
            $post->user_id      = $request->user_id;
            $post->content      = $request->content;
            $post->content_mm   = $request->content_mm;
            if($request->created_at)
                $post->created_at = $request->created_at;
            $post->save();
           
            if($post && $photos && is_array($photos)){
                foreach ($photos as $key => $name) {
                    $photo = new ResourcePhoto();
                    $photo->resource_post_id     = $post->id;
                    $photo->name                 = $name;
                    $photo->save();
                }
            }

            DB::commit();
            
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json('Something went wrong.', 400);
        }
        return response()->json($post);
    }

    public function postUpload(Request $request){
        $validator = Validator::make($request->all(), [
            'image'     => 'required',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('image')){
                return response()->json($validator->errors()->first('image'), 400);
            }
        }
        $photos = $request->image;
        $photoname = [];
        if(is_array($photos)){
            foreach ($photos as $key => $value) {
                $photoname[$key] = $this->upload($value, '/resource_posts_photo/');
            }
        }
        return response()->json($photoname);
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
