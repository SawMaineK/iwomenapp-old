<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AndroidErrorReport;

class AndroidErrorReportController extends Controller
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
            'stacktrace'          => 'required',
            'package_version'     => 'required',
            'package_name'        => 'required'
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('stacktrace'))
                return response()->json($validator->errors()->first('stacktrace'), 400);
            if($validator->errors()->has('package_version'))
                return response()->json($validator->errors()->first('package_version'), 400);
            if($validator->errors()->has('package_name'))
                return response()->json($validator->errors()->first('package_name'), 400);
        }

        $error_report = new AndroidErrorReport();
        $error_report->stacktrace = $request->stacktrace;
        $error_report->package_name = $request->package_name;
        $error_report->package_version = $request->package_version;
        $error_report->phone_model = $request->phone_model;
        $error_report->android_version = $request->android_version;
        $error_report->save();

        // Data to be used on the email view
        $data = array(
            'androidVersion'    => $request->android_version,
            'phoneModel'        => $request->phone_model,
            'packageName'       => $request->package_name,
            'packageVersion'    => $request->package_version,
            'stackTrace'        => $request->stacktrace
        );

        // Send the activation code through email
        Mail::send('emails.android-error', $data, function ($m) {
            $m->to('sawmainek90@gmail.com', 'Developers');
            $m->to('khinsandarwin1987@gmail.com', 'Developers');
            $m->subject('I-Women Error Report');
        });

        return response()->json($error_report);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        
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
