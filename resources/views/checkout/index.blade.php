<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayDZ Checkout</title>

    <style>
        body{
            font-family:Arial;
            background:#f5f5f5;
            padding:40px;
        }

        .card{
            width:500px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 5px 20px rgba(0,0,0,.1);
        }

        button{
            width:100%;
            padding:15px;
            margin-top:10px;
            font-size:18px;
            cursor:pointer;
        }

        .success{
            background:#0d6efd;
            color:white;
            border:none;
        }

        .danger{
            background:#dc3545;
            color:white;
            border:none;
        }
    </style>
</head>

<body>

<div class="card">

<h2>PayDZ Checkout</h2>

@if(session('success'))
<div style="color:green;">
{{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="color:red;">
{{ session('error') }}
</div>
@endif

<p><b>Payment ID:</b> {{ $payment->payment_id }}</p>

<p><b>Customer:</b> {{ $payment->customer_name }}</p>

<p><b>Email:</b> {{ $payment->customer_email }}</p>

<p><b>Amount:</b> {{ $payment->amount }} {{ $payment->currency }}</p>

<p><b>Status:</b> {{ $payment->status }}</p>

<hr>

<form method="POST" action="/pay/{{ $payment->payment_id }}/success">
@csrf

<button class="success">
Pay Successfully
</button>

</form>

<form method="POST" action="/pay/{{ $payment->payment_id }}/fail">
@csrf

<button class="danger">
Fail Payment
</button>

</form>

</div>

</body>
</html>
