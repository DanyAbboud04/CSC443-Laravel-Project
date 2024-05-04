<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .myNav {
            background: -webkit-linear-gradient(left, #003366, #004080, #0059b3, #0073e6);
            color: white;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10000;
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
            font-size:1.5rem;
            margin-left:60px;
        }

        .nav-ul li a {
            text-decoration: none;
            color: white;
            margin-right: 30px;
        }

        .center {
            display: flex; 
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            width: 50%;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }

        label {
            margin-top: 10px;
        }

        input, textarea, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #0073e6;
            color: white;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0059b3;
        }

        #createPostButton {
            position: fixed;
            top: 80px;
            z-index: 11000;
            width: 100px;
        }

        .error{
            display: flex;
            justify-content: center;
            font-size: 1.5rem;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <nav class="myNav">
        <ul class="nav-ul">
            <li>My App</li>
            <li><a href="{{ route('home.view') }}">Home</a></li>
            <li><a href="{{ route('signin') }}">Logout</a></li>
        </ul>
    </nav>
    @if($user->is_active)
    <div class="center" id="formContainer">
        <h1>Create Post</h1>
        <form id="postForm" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->user_id }}">
            <input type="hidden" name="first_name" value="{{ $user->first_name }}">
            <input type="hidden" name="last_name" value="{{ $user->last_name }}">

            <div>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div>
                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit">Submit Post</button>
        </form>
    </div>
    @elseif($user->is_guest)
        <div class="error">
            You are a guest, you cannot create posts
        </div>
    @else
        <div class="error">
            Your account is currently disabled, you cannot create new posts
        </div>
    @endif
</body>
</html>