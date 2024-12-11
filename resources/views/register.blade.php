<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
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
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            font-size: 0.9em;
            text-align: left;
            margin-top: -10px;
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
            margin-top: 15px;
            font-size: 0.9em;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .title-txt {
            font-size: 30px;
            color: #0c84ff;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <img src="/asset/frontend/images/includes/kr.png" alt="Keen Rabbits Logo" STYLE="width: 100px; margin-left: 0px;">
    <h2>Register</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror

        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        @error('email')
        <div class="error">{{ $message }}</div>
        @enderror

        <input type="password" name="password" placeholder="Password" required>
        @error('password')
        <div class="error">{{ $message }}</div>
        @enderror

        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        @error('password_confirmation')
        <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Register</button>
    </form>
    <div class="register-link">
        Already have an account? <a href="{{ route('login') }}">Login</a>
    </div>
</div>
</body>
</html>
