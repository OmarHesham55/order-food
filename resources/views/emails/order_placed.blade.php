<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
<h2>Thank you for your order</h2>
<p>Your order #{{ $order['id'] }} has been placed successfully.</p>
<p>Total: ${{ $order['total_price'] }}</p>

<p>We will notify you once your order is on the way!</p>
</body>
</html>
