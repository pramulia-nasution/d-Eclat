@extends('layouts.appLogin')

@section('content')
<form method="POST" class="form-signin" action="{{ route('login') }}">
    @csrf
    <div class="panel periodic-login">
        <center>
            <img style="width:150px;" src="{{asset('asset/img/logoo.png')}}" alt="">
        </center>  
        <div class="panel-body text-center">
            <div class="form-group form-animate-text" style="margin-top:40px !important;">
                <input id="email" type="email" class="form-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                <span class="bar"></span>
                <label>E-mail</label>
            </div>
            <div class="form-group form-animate-text" style="margin-top:40px !important;">
                <input id="password" type="password" class="form-text @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <span class="bar"></span>
                <label>Password</label>
            </div>
            <input type="submit" class="btn btn-success btn-gradient col-md-12" value="Login"/>
        </div>
    </div>
</form>

@endsection
