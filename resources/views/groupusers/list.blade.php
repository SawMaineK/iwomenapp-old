@extends('master')

@section('title', 'Group List')

@section('content')
<style type="text/css">
    .red-color{color:#4285F4;}
    table tr td{font-family: 'roboto','Zawgyi-One' !important;}
</style>
    <section id="content">
            <div class="container">
                             
                <div class="card">
                    <div class="card-header">
                        <h2>Group User List <small></small></h2>
                        <div id="filename" class="hide">Group User List</div>
                        <a href="#" id='btnExportExcel'><button type="submit" class="btn btn-primary btn-sm waves-effect pull-right">Export To Excel</button></a>
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
                                    <th data-column-id="id" data-visible="false" data-sortable="false">ID</th>
                                    <th data-column-id="group" data-formatter="group" data-sortable="false">Group</th>
                                    <th data-column-id="city" data-formatter="city" data-sortable="false">City</th>
                                    <th data-column-id="username" data-formatter="username" data-sortable="false" data-cssClass="zawgyi-one">Username</th>
                                    <th data-column-id="created_at" data-sortable="false">Created At</th>
                                    <th data-column-id="updated_at" data-sortable="false">Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($groupusers as $key=>$groupuserlist) 
                                        <tr data-row-id="{{$groupuserlist[0]['id']}}" id="groupbg">
                                            <td class="hide">{{$groupuserlist[0]['id']}}</td>
                                            <td>{{$groupuserlist[0]['group_name']}}</td>
                                            <td>{{$groupuserlist[0]['group_city']}}</td>
                                            <td>{{count($groupuserlist)}} (persons)</td>
                                            <td>...</td>
                                            <td>...</td>
                                        </tr>
                                    @foreach($groupuserlist as $groupuser)
                                        <tr data-row-id="{{$groupuser['id']}}">
                                            <td class="hide">{{$groupuser['id']}}</td>
                                            <td>{{$groupuser['group_name']}}</td>
                                            <td>{{$groupuser['group_city']}}</td>
                                            <td>{{$groupuser['username']}} [{{$groupuser['phone'].']'}}</td>
                                            <td>{{date('d-M-Y h:i A', strtotime($groupuser['created_at']))}}</td>
                                            <td>{{date('d-M-Y h:i A', strtotime($groupuser['updated_at']))}}</td>
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
    <script type="text/javascript" src="{{Request::root()}}/js/jquery.battatech.excelexport.min.js"></script>
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
                    rowCount: [50, -1],
                    // rowSelect: true,
                    keepSelection: true,
                    formatters: {
                        "group": function(columns, rows) {
                            if(rows.updated_at ==='...'){
                                return "<b class='red-color'>"+rows.group+"</b>";
                            }else{
                                return rows.group;
                            }
                        },
                        "city": function(columns, rows) {
                            if(rows.updated_at ==='...'){
                                return '<b class="red-color">'+rows.city+"</b>";
                            }else{
                                return rows.city;
                            }
                        },
                        "username": function(columns, rows) {
                            if(rows.updated_at ==='...'){
                                return '<b class="red-color">'+rows.username+"</b>";
                            }else{
                                return rows.username;
                            }
                        }
                        
                    }
                });

                var exporttoexcel=function(btnExportExcel, filename, tblExportID){
                      $(btnExportExcel).click(function () {
                         var uri =$('#'+tblExportID).btechco_excelexport({
                                containerid: tblExportID
                               , datatype: $datatype.Table
                               , returnUri: true
                            });
                         $(this).attr('download', filename+'.xls').attr('href', uri).attr('target', '_blank');
                      });
                }
                var filename=$('#filename').html();
                exporttoexcel('#btnExportExcel', filename, 'data-table-selection');
                
            });
        </script>
@endsection