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

    .user-container {
        margin-top: 30px;
        padding: 20px;
        display: none; 
    }

    .show-users{
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
    }

</style>
<body>
    <nav class="myNav">
        <ul class="nav-ul">
            <li>Admin Panel</li>
            <li><a href="{{ route('signin') }}">Logout</a></li>
        </ul>
    </nav>

    <div class="btn-container">
        <button class="show-users" id="toggleButton" onclick="toggleUsers()">
            Show Users
        </button>
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
                                
                            @else
                                <form action="{{ route('toggle-user-status', $user->user_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="deactivate-btn" style="{{ $user->is_active ? 'background-color: #ff4d4d;' : 'background-color: #4CAF50;' }}">
                                        {{ $user->is_active ? 'Deactivate' : 'Activate' }}
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

    <script>
        
        function toggleUsers() {
            var container = document.getElementById('userContainer');
            var toggleButton = document.getElementById('toggleButton');
            if (container.style.display === 'none') {
                container.style.display = 'block'; 
                toggleButton.textContent = 'Hide Users'; 
            } else {
                container.style.display = 'none'; 
                toggleButton.textContent = 'Show Users';
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            toggleUsers(); // This will set the initial display state to 'none'
        });
    </script>
</body>
</html>
