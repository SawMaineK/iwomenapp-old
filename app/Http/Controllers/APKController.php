<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;

use App\Apk;

class APKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $app = Apk::orderBy('created_at','desc')->first();
        return response()->json($app);
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
            'apk'           => 'required',
            'version_id'    => 'required|numeric|unique:apps,version_id',
            'version_name'  => 'required'
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('apk')){
                return response()->json($validator->errors()->first('apk'), 400);
            }
            if($validator->errors()->has('version_id')){
                return response()->json($validator->errors()->first('version_id'), 400);
            }
            if($validator->errors()->has('version_name')){
                return response()->json($validator->errors()->first('version_name'), 400);
            }
        }

        $apk_name = $this->uploadAPK($request->apk, '/apk/');

        $apps = new Apk();
        $apps->name = $apk_name;
        $apps->version_id = $request->version_id;
        $apps->version_name = $request->version_name;
        $apps->save();
        
        return response()->json($apps);
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
