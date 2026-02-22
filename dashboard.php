<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Soundify</title>
    <style>
        body {
            background:#121212;
            color:white;
            font-family:Arial;
            text-align:center;
            padding-top:50px;
        }
        a {
            color:#1db954;
        }
    </style>
</head>
<body>

<h1>Welcome, <?php echo $_SESSION['username']; ?> 👋</h1>

<p>This is your dashboard.</p>

<p><a href="index.php">Go to Soundify</a></p>
<p><a href="logout.php">Logout</a></p>

</body>
</html>