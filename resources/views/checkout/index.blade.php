<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Checkout</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="mb-4">
                <h4>Order Summary</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ $item->price }}</td>
                                <td>${{ $item->price * $item->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h4>Total: ${{ $total }}</h4>
            </div>
            <div class="mb-4">
                <h4>Payment Method</h4>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="stripe" value="stripe" checked>
                    <label class="form-check-label" for="stripe">
                        Stripe
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                    <label class="form-check-label" for="paypal">
                        PayPal
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    </div>
</body>
</html>
