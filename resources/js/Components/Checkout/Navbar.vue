<template>
<nav class="navbar">
    <div class="left">

        <div class="logo">
            <div class="logo-circle">
                P
            </div>

            <div>
                <h2>PayDZ</h2>
                <small>Secure Checkout</small>
            </div>

        </div>

    </div>

    <div class="right">

        <button class="theme">
            🌙
        </button>

    </div>
</nav>
</template>

<style scoped>

.navbar{

display:flex;

justify-content:space-between;

align-items:center;

padding:25px;

background:rgba(255,255,255,.05);

backdrop-filter:blur(30px);

border:1px solid rgba(255,255,255,.08);

border-radius:20px;

margin-bottom:25px;

}

.logo{

display:flex;

align-items:center;

gap:15px;

}

.logo-circle{

width:55px;

height:55px;

border-radius:50%;

background:linear-gradient(135deg,#4F46E5,#2563EB);

display:flex;

justify-content:center;

align-items:center;

font-size:28px;

font-weight:bold;

color:white;

box-shadow:0 0 40px #4F46E5;

}

.logo h2{

margin:0;

color:white;

}

.logo small{

color:#9CA3AF;

}

.theme{

width:48px;

height:48px;

border:none;

border-radius:15px;

background:#1f2937;

font-size:20px;

cursor:pointer;

color:white;

}

</style>
