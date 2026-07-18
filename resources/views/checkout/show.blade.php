<!DOCTYPE html>
<html lang="ar">

<head>

<meta charset="UTF-8">

<title>PayDZ Checkout</title>

<style>

body{
    background:#f5f7fb;
    font-family:Arial;
    direction:rtl;
}


.card{

    width:420px;
    margin:80px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 30px #ddd;

}


.logo{

    text-align:center;
    font-size:30px;
    font-weight:bold;
    color:#0066ff;

}


.amount{

    text-align:center;
    font-size:35px;
    margin:25px;

}


.info{

    padding:15px;
    background:#f1f1f1;
    border-radius:10px;

}


button{

    width:100%;
    padding:15px;
    background:#0066ff;
    color:white;
    border:none;
    border-radius:10px;
    font-size:18px;
    cursor:pointer;

}


button:hover{

    background:#004ecc;

}


</style>

</head>


<body>


<div class="card">


<div class="logo">
PayDZ
</div>


<h3 style="text-align:center">
{{ $session->merchant->business_name }}
</h3>


<div class="amount">

{{ $session->amount }}
{{ $session->currency }}

</div>



<div class="info">

<p>
العميل:
{{ $session->customer_name }}
</p>


<p>
البريد:
{{ $session->customer_email }}
</p>


<p>
الحالة:
{{ $session->status }}
</p>


</div>


<br>


<form method="POST" 
action="/api/v1/checkout/{{ $session->session_id }}/pay">

@csrf

<button>
ادفع الآن
</button>

</form>


</div>


</body>

</html>
