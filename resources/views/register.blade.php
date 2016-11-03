@extends('layouts.default')
@section ('content')
<link rel="stylesheet" type="text/css" href="css/style.css">
<div class="container-fluid bootstrap snippet">
    <div class="row">
		<div class="col-md-4 col-md-offset-4">
            @if ($response != null)
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ $response->info }}
            </div>
            @endif

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3>Register</h3>
                </div>
                <div class="panel-content">
                    <div class="container-fluid padding-20">
                        <form action="{{ url('/register') }}" method="post">
                            <div class="form-group">
                                <label for="register-form-username">Username</label>
                                <input id="register-form-username" name="username" type="text" class="form-control" placeholder="Enter username">
                            </div>
                            <div class="form-group">
                                <label for="register-form-password">Password</label>
                                <input id="register-form-password" name="password" type="password" class="form-control" placeholder="Enter password">
                            </div>
                            <div class="form-group">
                                <label for="register-form-password-confirmation">Password Confirmation</label>
                                <input id="register-form-password-confirmation" name="password-confirmation" type="password" class="form-control" placeholder="Enter password confirmation">
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <button type="submit" class="pull-right btn btn-primary">Submit</button>
                            </div>
                            <div class="form-group">
                                <a href="{{ url('/login') }}" class="text text-center">Already registered? Click here!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection