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

if (isset($_POST["btnLogin"])){
    echo ["user"];
    echo "Hello";
    $sql = 'CALL validateUser(?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_POST["user"]);
    if (!$stmt->execute())
    {
        echo "ERROR: " . $stmt->error;
    }
    else
    {
        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                if (password_verify(trim(["password"]), $row["passCode"]))
                {
                    session_regenerate_id();
                    $_SESSION["user"] = htmlspecialchars($_POST["user"]);
                    $_SESSION["type"] = $row["userType"];
                    $_SESSION["id"] = $row["userID"];

                    switch ($_SESSION["userType"])
                    {
                        case "main":
                            header('Location: main1.php');
                            break;

                        case "other":
                            header('Location: main2.php');
                            break;

                        default:
                            header('Location: logoff.php');
                            break;

                    }
                }
                else {
                    //incorrect password
                    header('location: mainPage.php?err=' . base64_encode("wrongPassword"));
                    die();
                }
            }

        }
        else {
            //incorrect user
            header('location: otherPage.php?err=' . base64_encode("wrongUser"));
            die();
        }
    }
    $stmt->close();
}
