@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Guest Room Allotment</h4></div>   
                <div class="panel-body">
                
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('flash::message') 
                       {!! Form::model($search_form_data_arr, ['url' => '/guest_info/guest_house_bookings', 'method'=>'GET']) !!}
                       <div class="form-group form-inline">
                           {!! Form::Label('From Date', 'From Date:') !!}
                           {!! Form::text('from_date', null, ['class'=>'form-control', 'id'=>'from_date'])!!}
                      
                           {!! Form::Label('To Date', 'To Date:') !!}
                           {!! Form::text('to_date', null, ['class'=>'form-control', 'id'=>'to_date'])!!}       
                           
                           
                           {!! Form::Label('Status', 'Status:') !!}
                           {!! Form::select('status', [''=>'-Select-', 0=>'Pending Check In', 1=>' Checked In', 2=>'Checked out'],  null, ['class'=>'form-control', 'id'=>'to_date'])!!}  
                           
                           {!! Form::submit('Search', ['class'=>'form-control bt btn-primary'])!!}
                           
                           {!! Form::submit('Reset', ['class'=>'form-control bt btn-primary', 'name'=>'reset'])!!}
                           
                           <a href="{{url('/guest_info/pending')}}" class="btn btn-success">All Records</a>
                       </div>
                       {!! Form::close() !!}
                    </div>
                   </div>       
                
                <table class="table table-hover table-striped table-bordered table-responsive">
                        <thead>
                 <tr >
                     <th>Id</th>
                     <th>Name</th>
                     <th>Contact No</th>
                     <th>Email</th>
                     <th>Address</th>                     
                     <th>Document Attached</th>
                     <th>Photo</th>
                     <th>Finger Print ID </th>
                     <th>Room no</th>
                     <th>Request By</th>
                     <th>Check In Date</th>
                     <th>Check Out Date</th>
                     <th>Total Bill Amount(in Rs)</th>
                 </tr>
                 </thead>
                 <tbody>
                 <?php $index = 1 ?>    
                 @foreach ($guest_info as $guest)
                     <tr>
                         <td>{{ $index ++ }}</td>
                         <td>{{ $guest->name }}</td>
                         <td>{{ $guest->contact_no }}</td>
                         <td>{{ $guest->email }}</td>
                         <td>{{ $guest->address }}</td>
                         <td>{{ $guest->document_type }}
                             @if($guest->doc)
                              - <a href="{{ url('/uploads/'.$guest->doc) }}">View</a>
                              @endif
                         </td>
                         
                         <td>
                             
                             @if($guest->guest_photo ) 
                             <a href="{{ $guest->guest_photo }}"> Guest photo </a>
                             @endif
                         </td>
                         
                        <td>
                            @if($guest->finger_print)
                             {{ $guest->finger_print }}
                             @endif
                        </td> 
                         
                         <td>
                             @if($guest->room_no ) 
                             <a href="{{ url('/room/'. $guest->room_id )}}"> {{ $guest->room_no }}</a>
                             @endif
                         </td>
                         <td>{{ $guest->request_by }}</td>
                         
                         <td>{{ $guest->check_in_date }}</td>
                         <td>{{ $guest->check_out_date }}</td>
                         
                         <td>{{ $guest->total_bill }}</td>                         
                     </tr>
                 @endforeach

                 </tbody>
                    </table>
                    {!! $guest_info->links() !!}
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
