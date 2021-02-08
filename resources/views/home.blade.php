@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">

                     <button id="kill" class="btn btn-danger m-t-15 waves-effect" type="button">Kill<span id="processId"></span></button> 
                     <button id="run" class="btn btn-success m-t-15 waves-effect float-right" type="button">Run</button> 
                     
                </div>
             </div>  
            <div class="card">
                <div class="card-body">
                    {!! form($fileform) !!}
                </div>
            </div> 
            <div class="card">
                <div class="card-header">{{ __('Configuration') }}
                <a href="{{route('download.config')}}" class="btn btn-success float-right">Download</a>
                </div>

                <div class="card-body">
                    {!! form($form) !!}
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Log') }}
                    <a href="{{route('download.log')}}" class="btn btn-success float-right">Download</a>

                    <button id="refresh" style="margin-right: 10px" class="btn btn-warning m-t-15 waves-effect float-right" type="button">Refresh</button>
                </div>
                
                <div class="card-body">

                    <textarea id="myLog" class="form-control" rows="20">{{$log}}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
function makeCall(param,type){
    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }); 
                $.ajax({
                   // async: true,
                    type: 'POST',
                    url: param,
                   // timeout: 1000,
                    success: function (result) {
                        
                        switch (type) {
                            case 'run':
                                console.log(result);
                                alert(result);
                                break;
                            case 'kill':
                                console.log(result);
                                alert(result);
                                break;
                            case 'log':
                                $('#myLog').text(result);
                                break;
                            
                            default:
                                
                        }

                        
                    }
                });
}
function updateProcess(processNo){
    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }); 
                $.ajax({
                    type: 'POST',
                    url: 'update-process',
                    success: function (result) {
                        if(result>0)
                         $("#processId").text("Process No : "+processNo)
                    }
                });
}
//setInterval(function(){ updateProcess(); }, 3000);
$( document ).ready(function() {
    $( "#kill" ).click(function() {
        makeCall('kill-process','kill');
    });
    $( "#run" ).click(function() {
       makeCall('run-process','run');
    });
    $( "#refresh" ).click(function() {
       makeCall('get-log','log');
    });
});
</script>
@endpush