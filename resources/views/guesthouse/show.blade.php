@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Guest House Info</div>
            <div class="panel-body">
                <form class="form-horizontal">
                <div class="form-group">
                    <label for="id" class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="isbn" placeholder={{$guesthouse->id}} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" placeholder={{$guesthouse->name}} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="author" placeholder={{$guesthouse->description}} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="owner" class="col-sm-2 control-label">Owner</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder={{$users->name}} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder={{$guesthouse->status?'Active':'InActive' }} readonly>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="{{ url('guesthouse')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </form>                
            </div>
        </div>
    </div>
</div>
@stop