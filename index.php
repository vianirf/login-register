<?php
session_start();
if (!isset($_SESSION["user"])) {  // jika session dengan array key belom ke set, diarahkan ke login.php
    header("Location: login.php");
}
print_r($_SESSION["user"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>User Dashboard</title>
</head>

<body>
    <div class="container">
        <h1>Welcome to the dashboard <?php echo $_SESSION["user"]; ?></h1>
        <p>echo</p>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>

</html>