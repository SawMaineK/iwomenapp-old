@extends('master')

@section('title', 'Competition Answer List')

@section('content')
<style type="text/css">
    #scrollbox{ width:auto;min-width: 200px; min-height: 60px; height:auto;  overflow:auto; overflow-x:hidden; border:1px solid #f2f2f2;  box-shadow: 0 0 1px 1px #ddd;}
    #scrollbox > p{color:#666; font-family:'Zawgyi-One', sans-serif; font-size:13px; padding:7px 9px; margin:0; }
    .red-color{color:#4285F4;}
</style>
    <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3>Competition Answer List <small></small></h3>
                        <!-- <a href="#/admin/competition-answer/create"><button type="submit" class="btn btn-primary btn-sm waves-effect">Create New Answer</button></a> -->
                    </div>
                    
                    @if(Session::has('messages'))
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    {{Session::get('messages')}}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(Session::has('warning'))
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    {{Session::get('warning')}}
                            </div>
                        </div>
                    </div>
                    @endif
                    

                    <div class="table-responsive">
                        <table id="data-table-selection" class="table table-striped">
                            <thead>
                                <tr>
                                    <!-- <th data-column-id="id" data-type="numeric" data-identifier="true">ID</th> -->
                                    <!-- <th data-column-id="id" data-identifier="false">ID</th> -->
                                    <th data-column-id="id" data-visible='false' data-sortable="false">ID</th>
                                    <th data-column-id="group" data-sortable="false" data-formatter="group">Group</th>
                                    <th data-column-id="username" data-sortable="false" data-formatter="username">User Name</th>
                                    <th data-column-id="answer" data-sortable="false" data-formatter="answer">Answer</th>
                                    <th data-column-id="answer_mm" data-visible='false' data-sortable="false" data-formatter="answer_mm">Answer_MM</th>
                                    <th data-column-id="date_time" data-sortable="false">Date Time</th>
                                    <th data-column-id="correct" data-sortable="false">Correct</th>
                                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($answers as $key=>$answerlist)
                                     <tr data-row-id="{{$answerlist[0]['id']}}">
                                        <td>{{$answerlist[0]['id']}}</td>
                                        <td>{{@$key}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @foreach($answerlist as $answer)
                                        <tr data-row-id="{{$answer['id']}}">
                                            <td>{{$answer['id']}}</td>
                                            <td>{{@$answer['competitiongroupuser']['group_name']}}</td>
                                            <td>{{@$answer['competitiongroupuser']['username']}}</td>
                                            <td>{{$answer['answer']}}</td>
                                            <td>{{$answer['answer']}}</td>
                                            <td><p>{{date('d-M-Y h:i A',strtotime($answer['updated_at']) + ((60*60) * 6.5))}}</p></td>
                                            <td>@if($answer['correct']==1) TRUE @else FALSE @endif</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
            </div>
        </section>
@endsection

@section('script')
    @parent

    <script type="text/javascript">
            $(document).ready(function(){
                //Selection
                $("#data-table-selection").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    selection: true,
                    multiSelect: true,
                    // rowSelect: true,
                    keepSelection: true,
                    formatters: {
                        "group": function(columns, rows) {
                            if(rows.answer_mm ===''){
                                return "<b class='red-color'>"+rows.group+"</b>";
                            }else{
                                return rows.group;
                            }
                        },
                        "username": function(columns, rows) {
                            if(rows.answer_mm ===''){
                                return "<b class='red-color'>"+rows.username+"</b>";
                            }else{
                                return rows.username;
                            }
                        },
                        "answer": function(columns, rows) {
                            if(rows.answer_mm ===''){
                                return "<b class='red-color'>"+rows.username+"</b>";
                            }else{
                                return "<div id='scrollbox'><p>"+rows.answer+"</p></div>";
                            }
                        },
                        "answer_mm": function(columns, rows) {
                            if(rows.answer_mm ===''){
                                return "<b class='red-color'>"+rows.username+"</b>";
                            }else{
                                return "<div id='scrollbox'><p>"+rows.answer_mm+"</p></div>";
                            }
                        },
                        "commands": function(column, row) {
                            if(row.answer_mm ===''){
                                return '';
                            }

                            if(row.correct==" TRUE "){
                                return "<a href='/admin/competition-answers-uncorrect/"+row.id+"'><button type=\"button\" class=\"btn btn-icon command-edit\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-close\"></span></button> </a>";
                            }else{
                                return "<a href='/admin/competition-answers-correct/"+row.id+"'><button type=\"button\" class=\"btn btn-icon command-edit\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-check\"></span></button> </a>";
                                
                            }
                        }
                    }
                });
                
            });
        </script>
        
@endsection