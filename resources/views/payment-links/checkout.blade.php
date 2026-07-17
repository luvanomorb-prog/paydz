<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<title>
{{ $link->title }} - PayDZ
</title>


<style>

body{

font-family: Arial;
background:#f5f7fb;
display:flex;
justify-content:center;
align-items:center;
height:100vh;

}


.card{

background:white;
width:420px;
padding:35px;
border-radius:20px;
box-shadow:0 10px 40px #ddd;
text-align:center;

}


.amount{

font-size:35px;
font-weight:bold;
color:#111;

}


button{

width:100%;
padding:15px;
border:0;
border-radius:10px;
background:#635bff;
color:white;
font-size:18px;
cursor:pointer;

}


.logo{

font-size:25px;
font-weight:bold;
color:#635bff;

}

</style>


</head>


<body>


<div class="card">


<div class="logo">
PayDZ
</div>


<h2>
{{ $link->title }}
</h2>


<p>
{{ $link->description }}
</p>



<div class="amount">

{{ number_format($link->amount,2) }}

{{ $link->currency }}

</div>



<br>


<form>

<button>

دفع الآن

</button>


</form>


</div>



</body>

</html>
