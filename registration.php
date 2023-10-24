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
    <title>Registration Form</title>
</head>

<body>
    <div class="container">
        <?php
        // print_r($_POST);   //check method post saat btn di klik
        if (isset($_POST["submit"])) {  //ketika submit di klik
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repeatPW = $_POST["repeat_password"];

            $passworDHash = password_hash($password, PASSWORD_DEFAULT); //secure password

            $error = array();
            //validation logic
            if (empty($fullName) or empty($email) or empty($password) or empty($repeatPW)) { //ketika semua field tidak diisi
                array_push($error, "All fields are requred");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($error, "Email is not valid");
            }

            if (strlen(($password) < 8)) {
                array_push($error, "Password at least 8 character");
            }

            if ($password !== $repeatPW) { //pw tidak sama dengan konfirmasi pw
                array_push($error, "Password doesnt match");
            }

            //query ketika email yg diisi di form, ternyata sudah ada di db
            require_once "database.php";
            $sql = "SELECT * FROM db_users WHERE email = '$email'"; // select dari table dbuser dimana nama kolom email di db sama dengan email yg diinput
            $result =  mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result); //number of row in the result
            if ($rowCount > 0) {
                array_push($error, "Email already exist");
            }




            if (count($error) > 0) {
                foreach ($error as $errors) {
                    echo "<div class ='alert alert-danger'>$errors </div>";
                }
            } else {
                //konek ke db
                require_once "database.php";
                $sql = "INSERT INTO db_users (full_name, email, password) VALUES (? , ? , ? )"; //Query insrt ke table db_users... ? pengganti value supaya tidak kena sql inject
                $stmt = mysqli_stmt_init($conn); // function ini mempunyai return prepare
                $prepare_stmt =  mysqli_stmt_prepare($stmt, $sql); // fuunction mereturn true or false, kalo ada error return false
                if ($prepare_stmt) {
                    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passworDHash);  // sss adalah singkatan dari 3 string, karena fullname, email, dan password adalah string.
                    mysqli_stmt_execute($stmt);  //eksekusi query
                    echo "<div class = 'alert alert-success'>Register Successfully</div>";
                } else {
                    die("Something went wrong");
                }
            }
        }

        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
    </div>
</body>

</html>