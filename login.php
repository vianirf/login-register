<?php
session_start();
if (isset($_SESSION["user"])) {  // jika session dengan array key sudah login, dia tidak bisa ke login.php lagi dan diarahkan ke index.php
    header("location: index.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Login Form</title>
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM db_users WHERE email = '$email'"; // select dari table dbuser dimana nama kolom email di db sama dengan email yg diinput
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC); //akses coloumn db with assoc
            if ($user) { // jika email eksis di db
                if (password_verify($password, $user["password"])) { // jika password ada di db. menggunakan password_verify karena sudah di hash di db ['password] adalah inputan form

                    //session : A session is a way to store information (in variables) to be used across multiple pages. 
                    session_start();
                    $_SESSION["user"] = $user['full_name']; //user sebagai array key dan value nya yes.. itu nama custom... 


                    header("Location: index.php"); // berhasil login dan diarahkan ke index
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else { // email belom ada di db
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Enter Email:">
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="Password:">
            </div>
            <div class="form-btn">
                <input type="submit" name="login" value="login" class="btn btn-primary">
            </div>
        </form>
    </div>
</body>

</html>