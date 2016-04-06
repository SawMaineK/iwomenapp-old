<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\CompetitionAnswer;
use URL;
use Input;

class CompetitionAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query=Input::get('q');
        $status=1;
        $title="Competition Answer List (Submitted)";
        if($query=='unsubimt'){
            $title="Competition Answer List (Unsubmitted)";
            $status=0;
        }
        $answerslist =CompetitionAnswer::where('status',$status)->with('competitiongroupuser')->orderBy('updated_at','asc')->get();
        $answers=array();
        if($answerslist){
            $grouparray=array();
            foreach ($answerslist as $key => $value) {
                if(isset($value->competitiongroupuser->group_name))
                    $grouparray[$value->competitiongroupuser->group_name][]=$value->toarray();
                $answers=$grouparray;
            }
        }
        // return response()->json($answers);
        return view('competitionanswer.list', compact('answers','title'));
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
        //
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
        // dd($id);
        // $anserid=$id;
        $objanswer=CompetitionAnswer::find($id);
        $objanswer->correct=1;
        $objanswer->update();
        return redirect(URL::previous());
    }


    public function correct($id){
        $objanswer=CompetitionAnswer::find($id);
        $objanswer->correct=1;
        $objanswer->update();
        return redirect(URL::previous());
        // return redirect(URL::previous());
    }

    public function uncorrect($id){
        $objanswer=CompetitionAnswer::find($id);
        $objanswer->correct=0;
        $objanswer->update();
        return redirect(URL::previous());
        // return redirect(URL::previous());
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
