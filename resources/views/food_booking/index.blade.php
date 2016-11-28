@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Book Food Order</h4></div>   
                <div class="panel-body">
                    <a href="{{url('/food_booking/create')}}" class="btn btn-success">New Booking</a>
                    <br>
                    <br>
                    <div class="panel panel-default">
                    <div class="panel-body">
                        @include('flash::message') 
                       {!! Form::model($search_form_data_arr, ['url' => 'food_booking', 'method'=>'GET']) !!}
                       <div class="form-group form-inline">
                           {!! Form::Label('From Date', 'From Date:') !!}
                           {!! Form::text('from_date', null, ['class'=>'form-control', 'id'=>'from_date'])!!}
                      
                           {!! Form::Label('To Date', 'To Date:') !!}
                           {!! Form::text('to_date', null, ['class'=>'form-control', 'id'=>'to_date'])!!}       
                           
                           
                           {!! Form::Label('Status', 'Status:') !!}
                           {!! Form::select('status', [''=>'All', 0=>'Rejected', 1=>'Accepted', 2=>'Pending'],  null, ['class'=>'form-control', 'id'=>'to_date'])!!}  
                           
                           {!! Form::submit('Search', ['class'=>'form-control bt btn-primary'])!!}
                       </div>
                       {!! Form::close() !!}
                    </div>
                   </div>    
                    
                    <table class="table table-striped table-bordered table-responsive">
                        <thead>
                 <tr >
                     <th>Id</th>
                     <th>No. of visitors</th>
                     <th>No. of Food  required</th>
                     <th>Date</th>
                     <th>Food Order</th>
                     <th>Purpose</th>
                     <th>Requested By</th>
                     <th>Status</th>
                     <th colspan="4">Actions</th>
                 </tr>
                 </thead>
                 <tbody>
                 <?php $index = 1 ?>    
                 @foreach ($food_booking as $book)
                     <tr>
                         <td>{{ $index ++ }}</td>
                         <td>{{ $book->no_of_visitors }}</td>
                         <td>{{ $book->quantity }}</td>
                         <td>{{ $book->date }}</td>
                         <td>
                             @if(is_array(json_decode($book->food_type)))
                                @foreach(json_decode($book->food_type) as $food)
                                    {{ ucfirst($food) }}
                                @endforeach
                             @endif
                         </td>
                         <td>{{ $book->purpose }}</td>
                         <td>{{ $book->user_name }}</td>
                         <td> {{ $book->status==2?'Pending':'' }} {{ $book->status==1?'Accepted':'' }} {{ $book->status==0?'Rejected':'' }} </td>
                         
                         @if(in_array('admin',$search_form_data_arr['check_role'])|| in_array('owner',$search_form_data_arr['check_role']))
                          @if($book->status==2)
                            <td>
                                {!! Form::model($food_booking,['method' => 'PATCH','route'=>['food_booking.update',$book->id]]) !!}
                                <button class="btn btn-primary">Accept</button>
                                {!! Form::hidden('status',1,null,['class'=>'form-control']) !!}
                                {!! Form::close() !!}
                            </td>
                           
                            <td>
                                {!! Form::model($food_booking,['method' => 'PATCH','route'=>['food_booking.update',$book->id]]) !!}
                                <button class="btn btn-primary">Reject</button>
                                {!! Form::hidden('status',0,null,['class'=>'form-control']) !!}
                                {!! Form::close() !!}
                            </td>
                            @endif
                         @endif
                         
                         @if(!in_array('owner',$search_form_data_arr['check_role'])) 
                            @if($book->status==2)
                               <td><a href="{{route('food_booking.edit',$book->id)}}" class="btn btn-warning">Edit</a></td>
                            @endif
                         <td>
                            {!! Form::open(['method' => 'DELETE', 'route'=>['food_booking.destroy', $book->id]]) !!}
                            <button class="btn btn-danger">
                               Delete
                            </button>
                            @endif
                            {!! Form::close() !!}
                         </td>
                     </tr>
                 @endforeach

                 </tbody>
                    </table>
                    @if(isset($_GET['from_date']))
                    {!! $food_booking->appends(array(
                                                    'from_date' => $_GET['from_date'],
                                                    'to_date'   => $_GET['to_date'],
                                                     'status'   => $_GET['status'],
                                                ))->links() !!}
                    @else
                    {!! $food_booking->links() !!}
                    @endif
                    
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
</div>

@endsection
