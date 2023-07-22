<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Welcome to your dashboard, {{ $user->name }}!</h1>
    <p>Your email is {{ $user->email }}</p>
    <div>WELCOME</div>
    <h2>Your Subscriptions</h2>
    <div>Your subscription is automatically renewed.</div>

     @foreach($subscriptionTypes as $type)
     <div class="card" style="margin: 25px 0;">
        <div style="font-weight:bold">{{ $type->name }}</div> 
        <div>₺{{ $type->price }} / Month</div>
        <button class="action subscribe" data-type-id="{{ $type->id }}">Subscribe</button>
    </div>
     @endforeach
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

     <script>
        // Attach an event listener to the 'Subscribe' buttons
        const subscribeButtons = document.querySelectorAll('.subscribe');
        const apiToken = localStorage.getItem('api_token');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        subscribeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const subscriptionTypeId = this.getAttribute('data-type-id');
                // Assume you have the access token stored in local storage
                // Send the subscription request to the API route with the access token included in the headers
                axios.post(`/api/user/{{ Auth::id() }}/subscription`, {
                    subscription_type_id: subscriptionTypeId
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        // Include the access token in the request headers
                        'Authorization': 'Bearer ' + apiToken,
                        // Include the CSRF token in the request headers
                        'X-CSRF-TOKEN': csrfToken
                    },
                })
                .then(response => {
                    console.log(response.data);
                    alert('Successfully subscribed!');
                    // You may update the UI or perform any other action upon successful subscription
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error occurred during subscription!');
                });
            });
        });
    </script>
</body>
</html>