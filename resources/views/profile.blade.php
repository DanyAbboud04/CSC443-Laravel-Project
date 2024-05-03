<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
        }

        .myNav {
            background: -webkit-linear-gradient(left, #003366, #004080, #0059b3, #0073e6);
            color: white;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .nav-ul {
            list-style: none;
            width: 100%; 
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-ul li:first-child {
            flex-grow: 1;
            text-align: center;
            font-size: 1.5rem;
            margin-left: 60px;
        }

        .nav-ul li a {
            text-decoration: none;
            color: white;
            margin-right: 30px;
        }

        .profile-container {
            margin-top: -100px;
            width: 80%;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 50%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #0073e6;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
            float: right; 
        }

        button:hover {
            background-color: #0059b3;
        }

        .success-message {
            padding: 10px;
            background-color: #dff0d8;
            color: #3c763d;
            margin-bottom: 20px;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
            text-align: center;
        }

        .center{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

    </style>
</head>
<body>
    @if($user->is_guest)
    <div class="center">
        You are a guest, no profile available
    </div>
    @else
    <nav class="myNav">
        <ul class="nav-ul">
            <li>My App</li>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('signin') }}">Logout</a></li>
        </ul>
    </nav>
    <div class="center">
        <div class="profile-container">
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif
            <h1>Profile Page</h1>
            <table>
                <tr>
                    <th>First Name:</th>
                    <td>
                        <form method="POST" action="{{ route('update.firstname') }}">
                            @csrf
                            <input type="text" name="first_name" value="{{ $user->first_name }}">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Last Name:</th>
                    <td>
                        <form method="POST" action="{{ route('update.lastname') }}">
                            @csrf
                            <input type="text" name="last_name" value="{{ $user->last_name }}">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>
                        <form method="POST" action="{{ route('update.email') }}">
                            @csrf
                            <input type="email" name="email" value="{{ $user->email }}">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Password:</th>
                    <td>
                        <form method="POST" action="{{ route('update.password') }}">
                            @csrf
                            <input type="password" name="new_password" placeholder="Enter new password" required>
                            <button type="submit">Reset Password</button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Active:</th>
                    <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endif
</body>
</html>
