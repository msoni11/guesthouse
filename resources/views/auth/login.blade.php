@extends('layouts.app_login')
@section('content')
<!--<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">Welcome</div>
                <div class="panel-body">
                    Welcome to Guest House booking management system. 
                </div>
                
    @if (Auth::guest())        
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/check_ldap') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">User Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}">

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    </div>
  </div>
 </div>            
</div>-->

<div class="page">
  <div class="generic">
    <div class="panel">
      <div class="title">
        <h1>Guest House Management System  </h1>
      </div>
      <div class="content">
          @if(isset($error))
                <div class="alert alert-danger">{{ $error }}</div>
                @endif
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/check_ldap') }}">
            {!! csrf_field() !!}
            
          <div class="contact-form">              
            <div class="users_role">
                <input type="radio" class="" name="role" value="admin"/> <strong> Admin </strong> 
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" class="" name="role" value="emp" checked/>  <strong> User </strong>
            </div>
            <label> <span>User Name</span>
            <input type="text" class="input_text" name="username" value="{{ old('username') }}"/>
            </label>
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif  
            <label> <span>Password</span>
            <input type="password" class="input_text" name="password" id="password"/>
            </label>
            @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif  

            <label> 
            <input type="submit" class="button" value="Login" id="login" />
            </label>
            <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>  
            
             <a class="btn btn-link" href="{{ url('/register') }}">New User</a>  
          </div>
        </form>
        <div class="address">
          <div class="panel">
            <div class="title">
              <p>  <img name="" src="{{ url('images/animated-img1.gif') }}" width="320" height="250" alt="" /></p>
            </div>
          
          </div>
         
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
