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

        @if(in_array($type->id, $activeSubscriptionTypeNames))
            <button class="action subscribed" data-type-id="{{ $type->id }}">You are already subscribed</button>
        @else
            <button class="action subscribe" data-type-id="{{ $type->id }}">Subscribe</button>
        @endif
    </div>
     @endforeach

     <h2>Your Transactions</h2>
     @foreach($transactions as $transaction)
         <div class="card" style="margin: 25px 0;">
             <div class="card-body">
                 <h5 class="card-title">Transaction ID: {{ $transaction->id }}</h5>
                 <p class="card-text">
                     <strong>User ID:</strong> {{ $transaction->user_id }}<br>
                     <strong>Subscription:</strong> {{ $transaction->subscription_type_name }}<br>
                     <strong>Price:</strong> {{ $transaction->price }}<br>
                     <strong>Created At:</strong> {{ $transaction->created_at }}<br>
                     <strong>Updated At:</strong> {{ $transaction->updated_at }}
                 </p>
             </div>
         </div>
     @endforeach

     <button class="logout">Logout</button>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script>
        // Attach an event listener to the 'Subscribe' buttons
        const subscribeButtons = document.querySelectorAll('.subscribe');
        const subscribedButtons = document.querySelectorAll('.subscribed');
        const logoutButton = document.querySelector('.logout');
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
                    location.reload();
                    // You may update the UI or perform any other action upon successful subscription
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error occurred during subscription!');
                });
            });
        });
        subscribedButtons.forEach(button => {
            button.addEventListener('click', function() {
                alert('You are already subscribed')
            });
        });

        logoutButton.addEventListener('click', function() {
            // Send the logout request to the API route with the access token included in the headers
            axios.post('/api/logout', {}, {
                headers: {
                        'Content-Type': 'application/json',
                        // Include the access token in the request headers
                        'Authorization': 'Bearer ' + apiToken,
                        // Include the CSRF token in the request headers
                        'X-CSRF-TOKEN': csrfToken
                },
            })
            .then(response => {
                // Successfully logged out
                console.log(response.data);
                alert('Successfully logged out!');
                // Clear the access token from local storage
                localStorage.removeItem('access_token');
                // Redirect the user to a new page
                window.location.href = '/login';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error occurred during logout!');
            });
        });

    </script>
</body>
</html>