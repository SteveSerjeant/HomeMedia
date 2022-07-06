<?php
session_start();

//connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'mysql';
$DATABASE_NAME = 'homemedia';

//establish connection
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()){

    //if error wit connection, stop and display error
    exit ('Failed to Connect:' . mysqli_connect_error());
}

if ($conn == false){

    die("Connection Error" . mysqli_connect_error());
}

//check if data submitted on form using isset()
if (!isset($_POST['user'], $_POST['password'])){

    exit('Please complete both fields!');
}

//prepare on SQL statement
//if ($stmt = $conn->prepare('CALL validationProcedure(?)))
if ($stmt = $conn->prepare('SELECT userID, passCode, userType FROM systemUsers WHERE userName = ?'))
{
    $stmt->bind_param('s', $_POST['user']);
    $stmt->execute();

    //store result from prepared statement
    $stmt->store_result();

    if ($stmt->num_rows > 0){
        $stmt->bind_result($userID, $passCode, $userType);
        $stmt->fetch();
        if ($_POST['password'] === $passCode){
            //verification successful, user logged in
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['user'] = $_POST['user'];
            $_SESSION[id] = $userID;
            $_SESSION['type'] = $userType;

            switch ($_SESSION["userType"])
            {
                case "main":
                    header('location: mainPage.php');
                    break;

                default:
                    header('location: logoff.php');

            }

        } else {
            //incorrect password
            header('location: mainPage.php?err=' . base64_encode("wrongPassword"));
            die();
        }
    }else {
        //incorrect user
        header('location: otherPage.php?err=' . base64_encode("wrongUser"));
        die();
    }

    $stmt->close();
}

