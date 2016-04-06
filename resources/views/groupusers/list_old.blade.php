@extends('master')

@section('title', 'Group List')

@section('content')
<style type="text/css">
    .red-color{color:#4285F4;}
</style>
    <section id="content">
            <div class="container">
                             
                <div class="card">
                    <div class="card-header">
                        <h2>Group User List <small></small></h2>
                        <!-- <a href="#/admin/groupusers/create"><button type="submit" class="btn btn-primary btn-sm waves-effect">Create New Group User</button></a> -->
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
                                    <th data-column-id="id" data-visible="false">ID</th>
                                    <th data-column-id="group" data-formatter="group">Group</th>
                                    <th data-column-id="city" data-formatter="city">City</th>
                                    <th data-column-id="username" data-formatter="username">Username</th>
                                    <th data-column-id="created_at">Created At</th>
                                    <th data-column-id="updated_at">Updated At</th>
                                    <!-- <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php 
                                    $last=null; 
                                ?>
                                @foreach($groupusers as $key=>$groupuserlist) 
                                        <tr data-row-id="{{$groupuserlist[0]['id']}}" id="groupbg">
                                            <td class="hide">{{$groupuserlist[0]['id']}}</td>
                                            <td>{{$groupuserlist[0]['group_name']}}</td>
                                            <td>{{$groupuserlist[0]['group_city']}}</td>
                                            <td>{{count($groupuserlist)}} (persons)</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @foreach($groupuserlist as $groupuser)
                                        <tr data-row-id="{{$groupuser['id']}}">
                                            <td class="hide">{{$groupuser['id']}}</td>
                                            <td>{{$groupuser['group_name']}}</td>
                                            <td>{{$groupuser['group_city']}}</td>
                                            <td>{{$groupuser['username'] .' ['.$groupuser['phone'].']'}}</td>
                                            <td>{{date('d-M-Y h:i A', strtotime($groupuser['created_at']))}}</td>
                                            <td>{{date('d-M-Y h:i A', strtotime($groupuser['updated_at']))}}</td>
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
                            if(rows.updated_at ===''){
                                return "<b class='red-color'>"+rows.group+"</b>";
                            }else{
                                return rows.group;
                            }
                        },
                        "city": function(columns, rows) {
                            if(rows.updated_at ===''){
                                return "<b class='red-color'>"+rows.city+"</b>";
                            }else{
                                return rows.city;
                            }
                        },
                        "username": function(columns, rows) {
                            if(rows.updated_at ===''){
                                return "<b class='red-color'>"+rows.username+"</b>";
                            }else{
                                return rows.username;
                            }
                        },
                        "commands": function(column, row) {
                            if(row.updated_at ===''){
                                return '';
                            }/*else{
                                return "<a href='/admin/groupusers/"+row.id+"/edit'><button type=\"button\" class=\"btn btn-icon command-edit\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> </a>" + 
                                "<a href='/admin/groupusers/"+row.id+"/delete'><button type=\"button\" class=\"btn btn-icon command-delete\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button>";    
                            }*/
                            
                        }
                    }
                });
                
            });
        </script>
@endsection