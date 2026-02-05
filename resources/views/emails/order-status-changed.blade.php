<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; border-radius: 5px; }
        .content { padding: 20px 0; }
        .order-details { background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0; }
        .status-badge { display: inline-block; padding: 5px 10px; border-radius: 3px; font-weight: bold; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-processing { background-color: #d1ecf1; color: #0c5460; }
        .status-shipped { background-color: #d4edda; color: #155724; }
        .status-delivered { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        .footer { text-align: center; padding: 20px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Order Status Update</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $order->user->name }},</p>
            
            <p>Your order status has been updated:</p>
            
            <div class="order-details">
                <h3>Order Details:</h3>
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Previous Status:</strong> <span class="status-badge status-{{ $oldStatus }}">{{ ucfirst($oldStatus) }}</span></p>
                <p><strong>New Status:</strong> <span class="status-badge status-{{ $newStatus }}">{{ ucfirst($newStatus) }}</span></p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y \a\t H:i') }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            </div>
    
    @if($newStatus == 'shipped')
        <p style="color: #28a745; font-weight: bold;">🚚 Great news! Your order has been shipped and is on its way to you.</p>
        @if($order->shipped_at)
            <p><strong>Shipped on:</strong> {{ $order->shipped_at->format('M d, Y \a\t H:i') }}</p>
        @endif
    @elseif($newStatus == 'delivered')
        <p style="color: #28a745; font-weight: bold;">🎉 Excellent! Your order has been delivered. We hope you enjoy your purchase!</p>
        @if($order->delivered_at)
            <p><strong>Delivered on:</strong> {{ $order->delivered_at->format('M d, Y \a\t H:i') }}</p>
        @endif
    @elseif($newStatus == 'processing')
        <p style="color: #007bff; font-weight: bold;">⚙️ Your order is now being processed and will be shipped soon.</p>
    @elseif($newStatus == 'cancelled')
        <p style="color: #dc3545; font-weight: bold;">❌ Your order has been cancelled. If you have any questions, please contact our support team.</p>
    @endif
            
            <p>You can track your order status anytime by <a href="{{ url('/orders') }}" style="color: #007bff; text-decoration: none;">logging into your account</a>.</p>
            
            <p>Thank you for your business!</p>
        </div>
        
        <div class="footer">
            <p>Best regards,<br><strong>{{ config('app.name') }} Team</strong></p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
            <p style="font-size: 12px; color: #999;">This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>
</html>