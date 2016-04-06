@extends('master')

@section('title', 'User List')



@section('content')
    <section id="content">
            <div class="container">
                             
                <div class="card">
                    <div class="card-header">
                        <h2>User List <small></small></h2>
                        <a href="/admin/users/create"><button type="submit" class="btn btn-primary btn-sm waves-effect">Create New User</button></a>
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
                                    <th data-column-id="id" data-visible="false">ID</th>
                                    <th data-column-id="name">Name</th>
                                    <th data-column-id="email" data-order="desc">Email</th>
                                    <th data-column-id="created_at" data-order="desc">Created At</th>
                                    <th data-column-id="updated_at" data-order="desc">Updated At</th>
                                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key=>$user)
                                <tr data-row-id="{{$user->id}}">
                                    <td class="hide">{{$user->id}}</td>
                                    <td>{{$user->first_name.' '.$user->last_name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->created_at}}</td>
                                    <td>{{$user->updated_at}}</td>
                                    <td></td>
                                </tr>
                                
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
                        "commands": function(column, row) {
                            return "<a href='/admin/users/"+row.id+"/edit'><button type=\"button\" class=\"btn btn-icon command-edit\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> </a>" + 
                                "<a href='/admin/users/"+row.id+"/delete'><button type=\"button\" class=\"btn btn-icon command-delete\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button>";
                        }
                    }
                });
                
                //Command Buttons
               /* $("#data-table-command").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {
                            return "<button type=\"button\" class=\"btn btn-icon command-edit\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button> " + 
                                "<button type=\"button\" class=\"btn btn-icon command-delete\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></button>";
                        }
                    }
                });*/
            });
        </script>
@endsection