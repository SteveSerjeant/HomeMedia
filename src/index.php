<!DOCTYPE HTML>
<html lang = "en">
<head>
    <title>Home Media</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel = "stylesheet" href="../css/stylesheet.css">

</head>
<body>
<h1 class="h1">Home Media Collection</h1>
</body>
</html>
<?php

include "functions.php";
?>
<br>
<div class="login">
    <h1>Login Page</h1>
    <form action="authenticate.php" method="post">

        <label for="username">
            <i class="fas fa-user"></i>

            <input type="text" name="user" placeholder="Username" id="user" required>
        </label>

        <lable for="password">
            <i class="fas fa-lock"></i>
        </lable>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <input type="submit" name="btnLogin" value="submit">
    </form>
</div>