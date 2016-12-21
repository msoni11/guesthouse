@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Room Details</div>
            <div class="panel-body">
                <form class="form-horizontal">
                <div class="form-group">
                    <label for="room_no" class="col-sm-2 control-label">Room No</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" placeholder='{{$rooms->room_no}}' readonly>
                    </div>
                </div>
               <div class="form-group">
                    <label for="room_type" class="col-sm-2 control-label">Room Type</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" placeholder='{{$rooms->room_type}}' readonly>
                    </div>
                </div>     
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="author" placeholder='{{$rooms->description}}' readonly>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="capacity" class="col-sm-2 control-label">Capacity</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="capacity" placeholder='{{$rooms->capacity}}' readonly>
                    </div>
                </div>   
                <div class="form-group">
                    <label for="guest house" class="col-sm-2 control-label">Guest House</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder='{{$guesthouse->name}}' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rent" class="col-sm-2 control-label">Rent</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="rent" placeholder='{{$rooms->rent}}' readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder={{$rooms->status?'Active':'InActive' }} readonly>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="{{ url('room')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </form>                
            </div>
        </div>
    </div>
</div>
@stop