@extends('master')

@section('title', 'Update Create')

@section('content')
<section id="content">
    <div class="container">
        <div class="block-header hide">
            <h2>Update User</h2>
            
           
        </div>

        
	
		<div class="card">
	        <div class="card-header">
	            <h2>	Update User <small></small></h2>
	        </div>
		    
		    @if ($errors->has())
		        <div class="row">
		        	<div class="col-sm-12">
				        <div class="alert alert-danger alert-dismissible" role="alert">
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			                    @foreach ($errors->all() as $key=>$error)
			                          ({{$key+1}}) {{ $error }} &nbsp;        
			                    @endforeach
			            </div>
		            </div>
	            </div>
	        @endif


	        
	        <div class="card-body card-padding">
	            <form action="/admin/users/{{$user->id}}" method="post">
		            <div class="row">
		                <div class="col-sm-6">                       
		                    <div class="input-group">
		                        <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
		                        <div class="fg-line">
		                                <input name="username" type="text" class="form-control" placeholder="Full Name" value="{{$user->username}}">
		                        </div>
		                    </div>
		                    
		                    <br/>
		                    
		                    <div class="input-group">
		                        <span class="input-group-addon"><i class="zmdi zmdi-local-phone"></i></span>
		                        <div class="fg-line">
		                            <input type="text" name="phone" class="form-control" placeholder="Contact Number" value="{{$user->phone}}">
		                        </div>
		                    </div>
		                    
		                    <br/>
		                    
		                    <div class="input-group">
		                        <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
		                        <div class="fg-line">
		                            <input type="text" name="email" class="form-control" placeholder="Email Address" value="{{$user->email}}">
		                        </div>
		                    </div>
		                    
		                    <br/>
		                    
		                    <div class="input-group">
		                        <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
		                        <div class="fg-line">
		                            <input type="password" name="password" class="form-control" placeholder="Password">
		                        </div>
		                    </div>
		                    <br/>

		                    <div class="input-group">
		                        <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
		                        <div class="fg-line">
		                            <input type="password" name="password_confirmation" class="form-control" placeholder="Comfirm Password">
		                        </div>
		                    </div>
		                    <br/>
		                    
		                </div>
		                
		            </div>
		            <div class="clearfix">&nbsp;</div>
		            <div class="row">
		            	<div class="col-sm-6">
		                	<button type="submit" class="btn btn-primary btn-sm waves-effect pull-right">Update</button>
		                	<!-- <a href="#" class="btn btn-primary btn-sm waves-effect">Cancel</a> -->
		                </div>
		            </div>
		        </form>
	            
	            <br/><br/>

	        </div>
	        
	        <br/>
	    </div>
	</div>
</section>
@endsection


