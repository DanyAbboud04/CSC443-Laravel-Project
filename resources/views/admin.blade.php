<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .myNav {
        background: -webkit-linear-gradient(left, #003366, #004080, #0059b3, #0073e6);
        color: white;
        height: 70px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
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
    .nav-ul li:nth-child(2) a{
        text-decoration:none;
        color: white;
        margin-right:30px;
    }
    .nav-ul li:nth-child(3) a{
        text-decoration:none;
        color: white;
        margin-right:30px;
    }
    .user-container, .post-container {
        margin-top: 30px;
        padding: 20px;
        display: none; 
    }

    .show-users, .show-posts {
        margin-top: 100px;
        padding: 20px;
        border: none;
        background: -webkit-linear-gradient(left, #003366, #004080, #0059b3, #0073e6);
        color: white;
        width: 10%;
        border-radius: 15px;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }

    .deactivate-btn {
        background: #ff4d4d;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-container{
        width: 100%;
        justify-content: center;
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
    }

    img.post-image {
        width: 100px;
        height: auto;
        border-radius: 5px;
    }

    .center{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size:1.5rem
        }


</style>
<body>
    <nav class="myNav">
        <ul class="nav-ul">
            <li>Admin Panel</li>
            <li><a href="{{ route('signin') }}">Logout</a></li>
        </ul>
    </nav>
    @if ($adminCheck === 1)
    <div class="btn-container">
        <button class="show-users action-btn" onclick="toggleVisibility('userContainer', this)">Show Users</button>
        <button class="show-posts action-btn" onclick="toggleVisibility('postContainer', this)">Show Posts</button>
    </div>

    <div class="user-container" id="userContainer">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Is Admin</th>
                    <th>Is Active</th>
                    <th>Is Guest</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin ? 'True' : 'False' }}</td>
                    <td>{{ $user->is_active ? 'True' : 'False' }}</td>
                    <td>{{ $user->is_guest ? 'True' : 'False' }}</td>
                    @if (!$user->is_admin) 
                        <td>
                            @if($user->is_guest)
                                <form action="{{ route('delete-guest', $user->user_id) }}" method="POST">  <!--going to route delete-guest and giving it user id-->
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="deactivate-btn" style="background-color: #ff4d4d;">
                                        Delete Guest
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('toggle-user-status', $user->user_id) }}" method="POST">  <!--metl abel bas gher route-->
                                    @csrf
                                    <button type="submit" class="deactivate-btn" style="{{ $user->is_active ? 'background-color: #ff4d4d;' : 'background-color: #4CAF50;' }}">
                                        {{ $user->is_active ? 'Deactivate User' : 'Activate User' }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    @else
                        <td></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="post-container" id="postContainer">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Author</th>
                    <th>Author Id</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->description }}</td>
                    <td>{{ $post->author }}</td>
                    <td>{{ $post->user_id }}</dd>
                    <td><img src="{{ asset($post->image) }}" alt="Post Image" class="post-image"></td>
                    <td>
                        <form action="{{ route('deletepost', ['id' => $post->post_id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="deactivate-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="center">
            You are not an admin, go back using logout button
        </div>
    @endif

    <script>
    function toggleVisibility(id, button) {
        var container = document.getElementById(id);
        var isVisible = container.style.display === 'block';  //check if container is visible
        container.style.display = isVisible ? 'none' : 'block'; //if yes make it none else block
        button.textContent = isVisible ? `Show ${id.includes('user') ? 'Users' : 'Posts'}` : `Hide ${id.includes('user') ? 'Users' : 'Posts'}`;  //changes button name hasab aya button houwe
        localStorage.setItem(id + '-visible', !isVisible);// Save the visibility state of the container in localStorage
    }

    document.addEventListener('DOMContentLoaded', () => {
        //get user w post
        var userContainer = document.getElementById('userContainer');
        var postContainer = document.getElementById('postContainer');

        // Get the visibility state of the containers from localStorage
        var userVisible = JSON.parse(localStorage.getItem('userContainer-visible'));
        var postVisible = JSON.parse(localStorage.getItem('postContainer-visible'));

        userContainer.style.display = userVisible ? 'block' : 'none'; //set display of container user
        postContainer.style.display = postVisible ? 'block' : 'none';//set display of container post

        //update buttons
        document.querySelector('.show-users').textContent = userVisible ? 'Hide Users' : 'Show Users';
        document.querySelector('.show-posts').textContent = postVisible ? 'Hide Posts' : 'Show Posts';
    });
</script>

</body>
</html>
