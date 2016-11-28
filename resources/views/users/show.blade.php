@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">User Info</div>
            <div class="panel-body">
                <form class="form-horizontal">
                <div class="form-group">
                    <label for="id" class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="id" placeholder="{{$user->id}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" placeholder="{{$user->name}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">User Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" placeholder="{{$user->username}}" readonly>
                    </div>
                </div>    
                <div class="form-group">
                    <label for="contact_no" class="col-sm-2 control-label">Contact No</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="contact_no" placeholder="{{$user->contact_no}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" placeholder="{{$user->email}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" placeholder="{{$user->address}}" readonly>
                    </div>
                </div>  
                <div class="form-group">
                    <label for="designation" class="col-sm-2 control-label">Designation</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="designation" placeholder="{{$user->designation}}" readonly>
                    </div>
                </div> 
                    <div class="form-group">
                    <label for="reg_date" class="col-sm-2 control-label">Registration Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="reg_date" placeholder="{{$user->reg_date}}" readonly>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="status" placeholder="{{$user->status?'Active':'InActive' }}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="{{ url('user')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </form>                
            </div>
        </div>
    </div>
</div>
@stop