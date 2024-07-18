<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{  asset('css/welcome.css')  }}">
    <title>My Passwords</title>
</head>

<body>
    <div class="half left">
        <h1>My Passwords</h1>
        <h3>Your key to security</h3>
    </div>
    <div class="half right">

        <section>
            <h1>Welcome</h1>
            <div class="text">
                <p>In the digital age, 
                    security is paramount. 
                    Safeguarding your sensitive information is no longer an option;
                     it's a necessity. Introducing My Passwords, 
                     your all-in-one solution for secure and effortless password 
                     management.

                </p>
            </div>

            
            
        </section>

        <div class="actions">
            <a href="{{ route('register') }}">
                <p>Register</p>
            </a>

            <a href="{{ route('login') }}">
                <p>Login</p>
            </a>


        </div>

    </div>

</body>

</html>