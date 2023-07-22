<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

    @error('name')
        <span class="text-danger">{{ $message }}</span>
    @enderror

    <form id="register-form">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Submit">
    </form>

    <script>
        document.getElementById('register-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            fetch("{{ route('api.register') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log({data})
                if (data?.success == 1) {
                    // Redirect the user to a new page
                    alert(data?.message);
                    window.location.href = '/login';
                } else {
                    alert(data?.message);
                }
            })
            .catch((error) => {
                console.error({error});
            });
        });
    </script>
</body>
</html>