@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">

                     <button id="kill" class="btn btn-danger m-t-15 waves-effect" type="button">Kill</button> 
                     <button id="run" class="btn btn-success m-t-15 waves-effect float-right" type="button">Run</button> 
                     
                </div>
             </div>  
            <div class="card">
                <div class="card-body">
                    {!! form($fileform) !!}
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
                <div class="card-header">{{ __('Log') }}
                    <a href="{{route('download.log')}}" class="btn btn-success float-right">Download</a>
                </div>
                
                <div class="card-body">

                    <textarea class="form-control" rows="20">{{$log}}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
function makeCall(param){
    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }); 
                $.ajax({
                    type: 'POST',
                    url: param,
                    success: function (result) {
                        alert(result);
                    }
                });
}
$( document ).ready(function() {
    $( "#kill" ).click(function() {
        makeCall('kill-process');
    });
    $( "#run" ).click(function() {
       makeCall('run-process');
    });
});
</script>
@endpush