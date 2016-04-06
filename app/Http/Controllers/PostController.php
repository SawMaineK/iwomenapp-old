<?php

namespace App\Http\Controllers;

use DB;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Post;
use App\Content;
use App\Photo;
use App\Like;
use App\Comment;
use App\Audio;
use App\Video;
use App\Role;
use App\RoleUser;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    	$role 	 = Input::get('role') ? Input::get('role') : 'Admin';
        $offset  = Input::get('offset') ? Input::get('offset') : 1;
        $limit   = Input::get('limit') ? Input::get('limit') : 6;

        $offset  = ($offset - 1) * $limit;

        $role = Role::where('name',$role)->pluck('id');

        if($role){
        	$role_user = RoleUser::where('role_id',$role)->lists('user_id');
        }

        if(count($role_user) > 0){
        	$posts = Post::with('contents','photos','category','author','user','audio','video')
	        			->wherein('user_id',$role_user)
	                        ->orderBy('created_at','desc')
	                            ->orderBy('total_likes','desc')
	                                ->offset($offset)->limit($limit)->get();
        }else{
	        $posts = Post::with('contents','photos','category','author','user','audio','video')
	                        ->orderBy('created_at','desc')
	                            ->orderBy('total_likes','desc')
	                                ->offset($offset)->limit($limit)->get();
        }

        
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
            'title'         => 'required|unique:posts,title',
            'title_mm'      => 'required|unique:posts,title_mm',
            'category_id'   => 'required|numeric',
            'user_id'       => 'required|numeric',
            'author_id'     => 'required|numeric',
            'contents'      => 'required',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('title'))
                return response()->json($validator->errors()->first('title'), 400);
            if($validator->errors()->has('title_mm'))
                return response()->json($validator->errors()->first('title_mm'), 400);
            if($validator->errors()->has('category_id'))
                return response()->json($validator->errors()->first('category_id'), 400);
            if($validator->errors()->has('user_id'))
                return response()->json($validator->errors()->first('user_id'), 400);
            if($validator->errors()->has('author_id'))
                return response()->json($validator->errors()->first('author_id'), 400);
            if($validator->errors()->has('contents'))
                return response()->json($validator->errors()->first('contents'), 400);
        }

        $content = json_decode($request->contents, true);
        if(!$content && !is_array($content)){
            return response()->json('Invalid content format.', 400);
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
            $post = new Post();
            $post->title        = $request->title;
            $post->title_mm     = $request->title_mm;
            $post->category_id  = $request->category_id;
            $post->author_id    = $request->author_id;
            $post->user_id      = $request->user_id;
            if($request->created_at)
                $post->created_at = $request->created_at;
            $post->save();
            if($post && $content && is_array($content)){
                foreach ($content as $key => $value) {
                    $content = new Content();
                    $content->post_id           = $post->id;
                    $content->short_content     = $value['short_content'];
                    $content->short_content_mm  = $value['short_content_mm'];
                    $content->content           = $value['content'];
                    $content->content_mm        = $value['content_mm'];
                    $content->save();
                }
            }

            if($post && $photos && is_array($photos)){
                foreach ($photos as $key => $name) {
                    $photo = new Photo();
                    $photo->post_id     = $post->id;
                    $photo->name        = $name;
                    $photo->save();
                }
            }

            if($post && $request->audio){
                $audio = new Audio();
                $audio->post_id = $post->id;
                $audio->name    = $request->audio;
                $audio->save();
            }

            if($post && $request->video){
                $video = new Video();
                $video->post_id = $post->id;
                $video->name    = $request->video;
                $video->save();
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
                $photoname[$key] = $this->upload($value, '/posts_photo/');
            }
        }
        return response()->json($photoname);
    }

    public function postUploadAudio(Request $request){

        $audio_name = $this->uploadAudio($request->uploaded_file, '/posts_audio/');
        
        return response()->json($audio_name);
    }

    public function postUploadVideo(Request $request){
        
        $video_name = $this->uploadAudio($request->uploaded_file, '/posts_video/');
        
        return response()->json($video_name);
    }

    public function postDownloadAudio($filename){
    	if(!$filename){
    		return response()->json('File name is required.', 400);
    	}
    	$file= public_path()."/posts_audio/".$filename;
        $headers = array(
              'Content-Type: application/audio',
            );
        return response()->download($file, $filename, $headers);
    }

    public function getCount($user_id){
        return Post::where('user_id', $user_id)->count();
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
