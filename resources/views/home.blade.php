<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
</style>
<body>
    <nav class="myNav">
        <ul class="nav-ul">
            <li>My App</li>
            <li><a href="#">View Profile</a></li>
            <li><a href="{{ route('signin') }}">Logout</a></li>
        </ul>
    </nav>
    
</body>
</html>
