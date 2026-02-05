<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update</title>
</head>
<body>
    <h2>Order Status Update</h2>
    
    <p>Dear {{ $order->user->name }},</p>
    
    <p>Your order status has been updated:</p>
    
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h3>Order Details:</h3>
        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
        <p><strong>Previous Status:</strong> {{ ucfirst($oldStatus) }}</p>
        <p><strong>New Status:</strong> {{ ucfirst($newStatus) }}</p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
        <p><strong>Total Amount:</strong> ${{ $order->total_amount }}</p>
    </div>
    
    @if($newStatus == 'shipped')
        <p>Great news! Your order has been shipped and is on its way to you.</p>
    @elseif($newStatus == 'delivered')
        <p>Excellent! Your order has been delivered. We hope you enjoy your purchase!</p>
    @elseif($newStatus == 'processing')
        <p>Your order is now being processed and will be shipped soon.</p>
    @endif
    
    <p>You can track your order status anytime by logging into your account.</p>
    
    <p>Thank you for your business!</p>
    
    <p>Best regards,<br>{{ config('app.name') }} Team</p>
</body>
</html>