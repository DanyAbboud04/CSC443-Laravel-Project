<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif; 
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
            font-size: 1.5rem;
            margin-left: 460px;
        }

        .nav-ul li a {
            text-decoration: none;
            color: white;
            margin-right: 30px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .post {
            width: 70%; 
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
        }

        .post img {
            max-width: 100%;
            height: 400px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .post p {
            margin: 0;
            line-height: 1.5;
        }

        .post-meta {
            color: #666;
            font-size: 0.9rem;
        }

        .center{
            width: 100%;
            justify-content:center;
            display:flex;
            margin-top:100px
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

        .edit-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 7px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 880px;

        }
    </style>
</head>
<body>
    <nav class="myNav">
        <ul class="nav-ul">
            <li>My App</li>
            <li><a href="{{ route('home.view') }}">All Posts</a></li>
            <li><a href="{{ route('home.view', ['mine' => 'true']) }}">My Posts</a></li>
            <li><a href="{{ route('createpost.view') }}">Create Post</a></li>
            <li><a href="{{ route('profile.view') }}">View Profile</a></li>
            <li><a href="{{ route('signin') }}">Logout</a></li>
        </ul>
    </nav>
    <div class="center">
        <h1>Posts</h1>
    </div>
    <div class="container">
    @foreach ($posts as $post)
        <div class="post">
            <div>
                @if ($post->user_id === auth()->id())
                    @if(session('success'))
                        <div class="success-message">
                            {{ session('success') }}
                        </div>
                    @endif
                @endif
                @if ($post->user_id === auth()->id())
                    <form action="{{ route('deletepost', ['id' => $post->post_id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete Post" class="delete-btn">
                    </form>
                @endif
                @if ($post->user_id === auth()->id())
                    <form action="{{ route('editpost', ['id' => $post->post_id]) }}" method="POST">
                        @csrf
                        <input type="text" name="title" value="{{ $post->title }}">
                        <input type="submit" value="Edit Title" class="edit-btn">
                        <input type="hidden" name="description" value="{{ $post->description }}">
                    </form>
                @else
                    <h2>{{ $post->title }}</h2>
                @endif
            </div>
            <img src="{{ asset($post->image) }}" alt="Post Image">
            <div>
                @if ($post->user_id === auth()->id())
                    <form action="{{ route('editpost', ['id' => $post->post_id]) }}" method="POST">
                        @csrf
                        <textarea name="description">{{ $post->description }}</textarea>
                        <input type="submit" value="Edit Description" class="edit-btn">
                        <input type="hidden" name="title" value="{{ $post->title }}">
                    </form>
                @else
                    <p>{{ $post->description }}</p>
                @endif
            </div>
            <div class="post-meta">
                <p>Posted by {{ $post->author }} at {{ $post->created_at }}</p>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
