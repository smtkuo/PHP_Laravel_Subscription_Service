<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add the CSRF token meta tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <form id="login-form">
        <!-- Add the CSRF token as a hidden input field -->
        @csrf
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Submit">
    </form>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('api.login') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // Include the CSRF token in the request headers
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data?.success) {
                    // Store the access token in local storage
                    console.log({data})
                    localStorage.setItem('api_token', data?.data?.api_token);

                    // Redirect the user to a new page
                    alert('Welcome')
                    window.location.href = '/dashboard';
                } else {
                    alert('Invalid credentials');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>