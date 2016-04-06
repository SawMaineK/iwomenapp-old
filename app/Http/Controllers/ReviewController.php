<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Validator;
use Input;

use App\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        $validator = Validator::make(Input::all(), [
            'function'      => 'required'
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('function'))
                return response()->json($validator->errors()->first('function'), 400);
        }

        $function = Input::get('function');

        $total_ratings  = Review::where('function',$function)->sum('ratings');
        $total_count    = Review::where('function', $function)->count();
        $ratings        = $total_ratings / $total_count;
        return response()->json(['total_ratings'=>round($ratings, 1),'total_users'=>$total_count]);
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
            'function'      => 'required',
            'user_id'       => 'required',
            'ratings'       => 'required',
        ]);

        if ($validator->fails()) {
            if($validator->errors()->has('function'))
                return response()->json($validator->errors()->first('function'), 400);
            if($validator->errors()->has('user_id'))
                return response()->json($validator->errors()->first('user_id'), 400);
            if($validator->errors()->has('ratings'))
                return response()->json($validator->errors()->first('ratings'), 400);
        }

        $review = Review::whereuser_id($request->user_id)->where('function', $request->function)->first();
        if($review){
            $review->ratings = $request->ratings;
            if($request->review)
                $review->feedback = $request->review;
            $review->update();
        }else{
            $review = new Review();
            $review->user_id = $request->user_id;
            $review->ratings = $request->ratings;
            $review->function = $request->function;
            if($request->review)
                $review->feedback = $request->review;
            $review->save();
        }

        return response()->json($review);
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
