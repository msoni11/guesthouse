<html>
<body>
<p>Dear Sir/Madam</p>
@if($status == 1)
    <p>This user has accpeted the checkout</p>
@elseif($status == 0)
    <p>This user has rejected the checkout</p>
@endif

<p>Thank You</p>
<p>HZL Team</p>
</body>
</html>
