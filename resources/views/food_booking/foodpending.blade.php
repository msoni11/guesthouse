@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>food</h4></div>   
                <div class="panel-body">
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('flash::message') 
                       {!! Form::model($search_form_data_arr, ['url' => '/food_booking/foodpending', 'method'=>'GET']) !!}
                       <div class="form-group form-inline">
                           {!! Form::Label('From Date', 'From Date:') !!}
                           {!! Form::text('from_date', null, ['class'=>'form-control', 'id'=>'from_date'])!!}
                      
                           {!! Form::Label('To Date', 'To Date:') !!}
                           {!! Form::text('to_date', null, ['class'=>'form-control', 'id'=>'to_date'])!!}       
                           
                           
                           {!! Form::submit('Search', ['class'=>'form-control bt btn-primary'])!!}
                           
                           {!! Form::submit('Reset', ['class'=>'form-control bt btn-primary', 'name'=>'reset'])!!}
                           
                           <a href="{{url('/food_booking/foodpending')}}" class="btn btn-success">All Records</a>
                       </div>
                       {!! Form::close() !!}
                    </div>
                   </div>       
                
                <table class="table table-hover table-striped table-bordered table-responsive">
                        <thead>
                 <tr >
                     <th>Id</th>
                     <th>No of Visitors</th>
                     <th>Quantity</th>
                     <th>Contact No</th>
                     <th>Food</th>
                     <th>Request By</th>
                     <th>Booking Status</th>
                     <th>Date</th>
                     <th colspan="4">Actions</th>
                 </tr>
                 </thead>
                 <tbody>
                 <?php $index = 1 ?>    
                 @foreach ($food_bookings as $booking)
                     <tr>
                         <td>{{ $index ++ }}</td>
                         <td>{{ $booking->no_of_visitors }}</td>
                         <td>{{ $booking->quantity }}</td>
                         <td>{{ $booking->contact_no }}</td>
                         <td>@if(is_array(json_decode($booking->food_type)))
                                @foreach(json_decode($booking->food_type) as $food)
                                    {{ ucfirst($food) }}
                                @endforeach
                             @endif
                         </td>
                         <td>{{ $booking->request_by }}</td>
                         <td>{{ $booking->status==3?'Pending from HOD':'' }} {{ $booking->status==2?'Pending from Guest owner':'' }} {{ $booking->status==1?'Accepted':'' }} {{ $booking->status==0?'Rejected':'' }}</td>
                         <td>{{ $booking->date }}</td>
                         @if($booking->served == 0)
                         <td> 
                                {!! Form::open(['method' => 'PATCH','route'=>['food_booking.update',$booking->id]]) !!}
                                <button class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-ok-sign"></span></button>
                                {!! Form::hidden('served',1,null,['class'=>'form-control']) !!}
                                {!! Form::close() !!}
                         </td>
                         @else
                         <td>
                             Completed
                         </td>
                         @endif
                     </tr>
                 @endforeach

                 </tbody>
                    </table>
                    {{--{!! $guest_info->links() !!}--}}
                </div>
            </div>
                 <script>
                    $(document).ready(function() {             
                     $('#from_date').datetimepicker({
                            format: "YYYY/MM/DD",
                      });
                     $('#to_date').datetimepicker({
                            format: "YYYY/MM/DD",
                      });
                    });
                 </script>
        </div>     
    </div> 
</div>

@endsection
