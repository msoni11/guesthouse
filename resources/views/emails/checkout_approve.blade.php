<html>
<body>    
    <p>Dear Sir/Madam</p>
    <p>Please check  details and click on accept/reject link for further approval.</p>
    <p>Click Here: <a href="{{$links['accept']}}">Accept</a>/<a href="{{$links['reject']}}">Reject</a></p>
    <table border="1" style='border-collapse: collapse'>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">No. of visitors</td><td width="50%">{{$booking_request->no_of_visitors}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">No. of rooms required</td><td width="50%">{{$booking_request->required_room}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Type of Guest</td><td width="50%">{{$booking_request->type_of_guest}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Check In Date</td><td width="50%">{{$booking_request->check_in_date}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Check Out Date</td><td width="50%">{{$booking_request->check_out_date}}</td>
        </tr>

        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Food Order</td><td width="50%">@if($booking_request->food_order)
                    @foreach($booking_request->food_order as $food)
                        {{ ucfirst($food) }}
                    @endforeach
                @endif </td>
        </tr>

        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Org Name & Address</td><td width="50%">{{$booking_request->org_name_address	}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Purpose</td><td width="50%">{{$booking_request->purpose}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Remark</td><td width="50%">{{$booking_request->remark}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Request By</td><td width="50%">{{$users->name}}</td>
        </tr>
        <tr border="1">
            <td width="50%">Status</td><td width="50%">{{ $booking_request->status==3?'Pending from HOD':'' }}{{ $booking_request->status==2?'Pending from owner':'' }} {{ $booking_request->status==1?'Accept':'' }} {{ $booking_request->status==0?'Reject':'' }}</td>
        </tr>
    </table>

    <p></p>

        <p><strong>Guest Information:</strong></p>

    <table border="1" style='border-collapse: collapse'>
        <tr border="1" style='border-collapse: collapse'>
            <th>Guest Name</th>
            <th>Contact No</th>
            <th>Email</th>
            <th>Address</th>
            <th>Attached Document Type</th>
        </tr>

           <tr border="1" style='border-collapse: collapse'>
                <td>{{$guest_info->name}}</td>
                <td>{{$guest_info->contact_no}}</td>
                <td>{{$guest_info->email}}</td>
                <td>{{$guest_info->address}}</td>
                <td>{{$guest_info->document_type}}</td>
            </tr>
        </table>

    <p></p>
    <?php $total_price = 0; ?>
    @if($foods)
        <p><strong>Food Details:</strong></p>
        <table border="1" style='border-collapse: collapse'>
            <tr border="1" style='border-collapse: collapse'>
                <th>Food Item</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            @foreach($foods as $food)
                <tr border="1" style='border-collapse: collapse'>
                    <td>{{$food->name}}</td>
                    <td>{{$food->quantity}}</td>
                    <td>{{$food->price}}</td>
                    <div style="display:none"> {!! $total_price += ($food->quantity*$food->price) !!}</div>
                </tr>
            @endforeach
            <tr>
            <td></td>
            <td><strong>Total</strong>(in Rs)</td>
            <td>{{$total_price}}</td>
            </tr>
        </table>
    @endif

    <p>Thank You</p>
    <p>HZL Team</p>
</body>
</html>
