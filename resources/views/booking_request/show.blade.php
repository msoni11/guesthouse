@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panel-default">Booking Request Info</div>
            <div class="panel-body">
                <form class="form-horizontal">
                <div class="form-group">
                    <label for="no_of_visitors" class="col-sm-2 control-label">No. of visitors</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_of_visitors" placeholder={{$booking_request->no_of_visitors}} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="required_room" class="col-sm-2 control-label">No. of rooms required</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="required_room" placeholder={{$booking_request->required_room}} readonly>
                    </div>
                </div>
                    <div class="form-group">
                    <label for="type_of_guest" class="col-sm-2 control-label">Type of Guest</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="type_of_guest" placeholder={{$booking_request->type_of_guest}} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="check_in_date" class="col-sm-2 control-label">Check In Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="check_in_date" placeholder={{$booking_request->check_in_date}} readonly>
                    </div>
                </div>
                    <div class="form-group">
                    <label for="check_out_date" class="col-sm-2 control-label">Check Out Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="check_out_date" placeholder={{$booking_request->check_out_date}} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="food_order" class="col-sm-2 control-label">Food Order</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="food_order" placeholder="
                        @if($booking_request->food_order)
                            @foreach($booking_request->food_order as $food) 
                            {{ ucfirst($food) }}
                            @endforeach
                        @endif    
                      "  readonly>  
                    </div>
                </div>
                    <div class="form-group">
                    <label for="purpose" class="col-sm-2 control-label">Purpose</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="purpose" placeholder={{$booking_request->purpose}} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="remark" class="col-sm-2 control-label">Remark</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="remark" placeholder={{$booking_request->remark}} readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="user" class="col-sm-2 control-label">Request By</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder="{{$users->name}}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder="{{ $booking_request->status==2?'Pending':'' }} {{ $booking_request->status==1?'Accept':'' }} {{ $booking_request->status==0?'Reject':'' }}" readonly>
                    </div>
                </div>
                    {{ $count = '' }}
                    @foreach($guest_info as $guest)
                    <hr>
                    <div class="form-group form-inline">   
                        <label for="" class="control-label col-sm-2">{{$count = $count + 1}}) Guest Name:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" id="guest_name" placeholder="{{$guest->name}}" readonly>
                        </div>
                        <label for="guest contact no" class="control-label col-sm-2">Guest Contact No:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" id="guest_contact_no" placeholder="{{$guest->contact_no}}" readonly>
                        </div>
                        <label for="email" class="control-label col-sm-2">Guest Email:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" id="guest_email" placeholder="{{$guest->email}}" readonly>
                        </div>
                    </div>   
                    <div class="form-group form-inline">                           
                        <label for="guest address" class="control-label col-sm-2">Guest Address:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" id="guest_address" placeholder="{{$guest->address}}" readonly>
                        </div>
                        <label for="Attach Document" class="control-label col-sm-2">Attached Document Type:</label>
                        <div class="col-sm-2">
                        <input type="text" class="form-control" id="attach document" placeholder="{{$guest->document_type}}" readonly>
                        </div>
                        <div class="col-sm-2">
                            @if($guest->doc) 
                            
                            <span class=""> <a  href="{{ url('/uploads/'.$guest->doc) }}"><img src="{{ url('/uploads/'.$guest->doc) }}" height="40px" width="60px"></a>
                            <a  href="{{ url('/uploads/'.$guest->doc) }}"> View Full  </a>
                            </span>
                        @endif 
                        </div>
                    </div>    
                    @endforeach
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="{{ url('booking_request')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </form>                
            </div>
        </div>
    </div>
</div>
@stop