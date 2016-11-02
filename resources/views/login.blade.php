@extends('layouts.default')
@section ('content')
<link rel="stylesheet" type="text/css" href="css/style.css">
<div class="container-fluid bootstrap snippet">
    <div class="row">
		<div class="col-md-4 col-md-offset-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3>Login</h3>
                </div>
                <div class="panel-content">
                    <div class="container-fluid padding-20">
                        <form action="{{ url('/login') }}" method="post">
                            <div class="form-group">
                                <label for="login-form-username">Username</label>
                                <input id="login-form-username" name="username" type="text" class="form-control" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="login-form-password">Password</label>
                                <input id="login-form-password" name="password" type="password" class="form-control" placeholder="Enter password">
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <button type="submit" class="pull-right btn btn-success">Submit</button>
                            </div>
                            <div class="form-group">
                                <a href="{{ url('/register') }}" class="text text-center">Not registered? Click here!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection