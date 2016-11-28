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
                       {!! Form::model($search_form_data_arr, ['url' => '/guest_info/foodpending', 'method'=>'GET']) !!}
                       <div class="form-group form-inline">
                           {!! Form::Label('From Date', 'From Date:') !!}
                           {!! Form::text('from_date', null, ['class'=>'form-control', 'id'=>'from_date'])!!}
                      
                           {!! Form::Label('To Date', 'To Date:') !!}
                           {!! Form::text('to_date', null, ['class'=>'form-control', 'id'=>'to_date'])!!}       
                           
                           
                           {!! Form::submit('Search', ['class'=>'form-control bt btn-primary'])!!}
                           
                           {!! Form::submit('Reset', ['class'=>'form-control bt btn-primary', 'name'=>'reset'])!!}
                           
                           <a href="{{url('/guest_info/foodpending')}}" class="btn btn-success">All Records</a>
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
                     <th>Food</th>
                     <th>Request By</th>
                     <th>Date</th>
                     <th colspan="4">Actions</th>
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
                         <td>@if(is_array(json_decode($guest->food_type)))
                                @foreach(json_decode($guest->food_type) as $food)
                                    {{ ucfirst($food) }}
                                @endforeach
                             @endif
                         </td>
                         <td>{{ $guest->request_by }}</td> 
                         <td>{{ $guest->date }}</td>
<!--                         <td><a href="{{url('guest_info',$guest->id)}}" class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span></a></td>
                         <td><a href="{{route('guest_info.edit',$guest->id)}}" class="btn btn-warning"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a></td>-->
                         @if($guest->served == 0)
                         <td> 
                                {!! Form::open(['method' => 'PATCH','route'=>['guest_info.update',$guest->id]]) !!}
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
