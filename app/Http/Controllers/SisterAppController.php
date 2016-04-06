<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\SisterApp;

class SisterAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sister_apps = SisterApp::all();
        return response()->json($sister_apps);
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
            'name'          => 'required|unique:sister_apps',
            'package_name'  => 'required',
            'link'          => 'required',
            'image'         => 'required',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('name'))
                return response()->json($validator->errors()->first('name'), 400);
            if($validator->errors()->has('package_name'))
                return response()->json($validator->errors()->first('package_name'), 400);
            if($validator->errors()->has('link'))
                return response()->json($validator->errors()->first('link'), 400);
            if($validator->errors()->has('image'))
                return response()->json($validator->errors()->first('image'), 400);
        }

        $app = new SisterApp();
        $app->name = $request->name;
        $app->package_name = $request->package_name;
        $app->link = $request->link;
        $app->image = $request->image;
        $app->save();

        return response()->json($app);


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

        $name = $this->upload($request->image, '/sister_app_photo/');
        
        return response()->json($name);
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
