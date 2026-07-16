<!DOCTYPE html>
<html>
<head>
    <title>PayDZ Checkout</title>
</head>

<body>

<h1>PayDZ Checkout</h1>

<hr>

<p><strong>Amount:</strong> {{ $payment->amount }} {{ $payment->currency }}</p>

<p><strong>Description:</strong> {{ $payment->description }}</p>

<p><strong>Status:</strong> {{ $payment->status }}</p>

<hr>

<h2>Select payment method</h2>

<button>CIB</button>

<button>Edahabia</button>

</body>
</html>
