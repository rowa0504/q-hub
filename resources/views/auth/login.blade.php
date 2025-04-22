<!DOCTYPE html>
<html>
<head>
    <title>Login - Qhub</title>
    <style>
        body {
            background: #222;
            color: #000;
            font-family: 'Arial', sans-serif;
        }
        .card {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
        }
        img.logo {
            width: 120px;
            margin-bottom: 30px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            background: #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            background: #00c2e9;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="/logo.png" alt="logo" class="logo">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>