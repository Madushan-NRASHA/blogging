<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-image: url('/images/bg.jpeg'); */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .register-link {
            text-align: center;
            margin-top: 1rem;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-link a:hover {
            t
            ext-decoration: underline;
        }
        #error_msg{
            position: relative;
            left: -5px;
            color: red;
        }
        .title-txt{
            position: relative;
            left:10px;
            font-size: 30px;
            color: #0c84ff;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <img src="/asset/frontend/images/includes/kr.png" alt="Keen Rabbits Logo" STYLE="width: 100px; margin-left: 100px;">
        <h2>Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
            <p id="error_msg"></p>
        </div>
    </div>


    @if ($errors->any())
        <script>
            let errorMessages = "";
            var dispMsg=document.getElementById('error_msg');
            @foreach ($errors->all() as $error)
                errorMessages += "{{ $error }}\n";
            @endforeach

            dispMsg.innerHTML=errorMessages;

        </script>
    @endif


</body>
</html>
