<html>
<body>    
    <p>Dear Sir/Madam</p>
    <p>Please  check Final bill details.</p>
    <table border="1" style='border-collapse: collapse'>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Guest Name</td><td width="50%">{{$guestroomallotment->name}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Guest Contact No</td><td width="50%">{{$guestroomallotment->contact_no}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Guest Email</td><td width="50%">{{$guestroomallotment->email}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Guest Address</td><td width="50%">{{$guestroomallotment->address}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Check In Date</td><td width="50%">{{$guestroomallotment->check_in_date}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Check Out Date</td><td width="50%">{{$guestroomallotment->check_out_date}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Room No</td><td width="50%">{{$guestroomallotment->room_no}}</td>
        </tr>
        <tr border="1" style='border-collapse: collapse'>
            <td width="50%">Room Type</td><td width="50%">{{$guestroomallotment->room_type}}</td>
        </tr>
    </table>
    <p></p>
    <?php $total_price = 0; ?>
    @if($foods)
    <p><strong>Food Details:</strong></p>
    <table border="1" style='border-collapse: collapse'>
        <tr border="1" style='border-collapse: collapse'>
            <th>Food Item</th><th>Quantity</th><th>Price</th>
        </tr>
        @foreach($foods as $food)
            <tr border="1" style='border-collapse: collapse'>
                <td>{{$food->name}}</td><td>{{$food->quantity}}</td><td>{{$food->price}}</td>
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