@extends('layouts.temp')

@section('content')
    <div class="col-md-4 col-md-offset-4 padding-0">
        <div class="panel box-v2">
            <div class="panel-heading padding-0">
            <img src="asset/img/logo.png" style="background-color:white" class="box-v2-cover img-responsive"/>
            <div class="box-v2-detail">
                <img src="asset/img/avatar.jpg" class="img-responsive"/>
                <h4 style="color:green;font-size:15px;">{{Auth::user()->name}}</h4>
            </div>
            </div>
            <div class="panel-body">
            <div class="col-md-12 padding-0 text-center">
                    <h4>PENERAPAN ALGORITMA DECLAT DALAM IDENTIFIKASI PEMAKAIAN NAPZA </h4>
                    <p>(Studi Kasus BNNP Riau)</p>
            </div>
            </div>
        </div>
    </div>
@endsection