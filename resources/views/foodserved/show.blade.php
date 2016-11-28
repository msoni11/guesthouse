@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panel-default">Guest Info</div>
            <div class="panel-body">
                <form class="form-horizontal">
                <div class="form-group">
                    <label for="id" class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="isbn" placeholder="{{$guest_info->id}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" placeholder="{{$guest_info->name}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact_no" class="col-sm-2 control-label">Contact No</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="author" placeholder="{{$guest_info->contact_no}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder="{{$guest_info->email}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder="{{$guest_info->address}}" readonly>
                    </div>
                </div>                    
                 <div class="form-group">
                    <label for="doc" class="col-sm-2 control-label">Photo</label>
                    <div class="col-sm-10">
                        @if($guest_info->guest_photo ) 
                             <img src="{{ $guest_info->guest_photo }}" max-height="200px" max-width="200px">
                             @endif
                    </div>
                </div> 
                <div class="form-group">
                    <label for="doc" class="col-sm-2 control-label">Attached Document Type</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder="{{$guest_info->document_type}}" readonly>
                    </div>
                </div>     
                <div class="form-group">
                    <label for="doc" class="col-sm-2 control-label">Document Picture</label>
                    <div class="col-sm-10">
                        @if($guest_info->doc ) 
                             <a href="{{ url('/uploads/'.$guest_info->doc) }}"><img src="{{ url('/uploads/'.$guest_info->doc) }}" max-height="200px" max-width="2000px" /></a>
                             @endif
                    </div>
                </div> 
                <div class="form-group">
                    <label for="doc" class="col-sm-2 control-label">Finger Print</label>
                    <div class="col-sm-10">
                        @if($guest_info->guest_photo ) 
                             <a href="{{ url('/uploads/'.$guest_info->finger_print) }}"><img src="{{ url('/uploads/'.$guest_info->finger_print) }}" max-height="200px" max-width="100px" /></a>
                             @endif
                    </div>
                </div>     
                    
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder={{$guest_info->status?'Active':'InActive' }} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="{{ url('guest_info')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </form>                
            </div>
        </div>
    </div>
</div>
@stop