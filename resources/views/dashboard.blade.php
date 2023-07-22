<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to your dashboard, {{ $user->name }}!</h1>
    <p>Your email is {{ $user->email }}</p>
    <div>WELCOME</div>

    <h2>Your Subscriptions</h2>
    <div></div>
     @foreach($subscriptionTypes as $type)
     <div class="card" style="margin: 25px 0;">
        <div style="font-weight:bold">{{ $type->name }}</div> 
        <div>₺{{ $type->price }} / Ay</div>
        <div><button class="action">Abone Ol</button></div>
    </div>
     @endforeach

</body>
</html>