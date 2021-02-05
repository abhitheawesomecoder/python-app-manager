@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">

                     <button class="btn btn-danger m-t-15 waves-effect" type="button">Kill</button> 
                     <button class="btn btn-success m-t-15 waves-effect float-right" type="button">Run</button> 
                     
                </div>
             </div>   
            <div class="card">
                <div class="card-header">{{ __('Configuration') }}</div>

                <div class="card-body">
                    {!! form($form) !!}
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Log') }}</div>
                
                <div class="card-body">

                    <textarea class="form-control" rows="20">{{$log}}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
