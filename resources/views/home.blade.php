@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Configuration') }}</div>

                <div class="card-body">
                    {!! form($form) !!}
                </div>
            </div>
        </div>
        <div class="col-md-8">
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
