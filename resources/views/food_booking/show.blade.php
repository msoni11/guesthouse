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
                     <label for="contact_no" class="col-sm-2 control-label">Contact no</label>
                     <div class="col-sm-10">
                         <input type="text" class="form-control" id="contact no" placeholder={{$booking_request->contact_no}} readonly>
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
                    <label for="status" class=" col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="publisher" placeholder={{ $booking_request->status==2?'Pending':'' }} {{ $booking_request->status==1?'Accept':'' }} {{ $booking_request->status==0?'Reject':'' }} readonly>
                    </div>
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