<?php
session_start();
include '../db/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user exists
    $query = "SELECT * FROM Admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && $admin['password'] === $password) { 
        $_SESSION['admin'] = $admin['id'];
        header("Location: index.php");
        exit(); 
    } else {
        $error = "Salah username or password!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
    body {
        background-image: url("../assets/images/backgroundlogin.jpg");
    }
    </style>


</head>

<body>

    <div class="card login-card">
        <h2 class="text-center">Admin Login</h2>
        <?php if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        } ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" placeholder="Masukkan username" class="form-control" id="username" name="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" placeholder="Masukkan password" class="form-control" id="password"
                    name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div class="mt-3 text-center">
                <a href="../index.php">Kembali ke Home</a>
                <br>
                <small class="text-muted mt-2 d-block">Username : admin | Password : admin</small>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcqC1x2bI7t+Q+jYwS6tL2xS"
        crossorigin="anonymous"></script>
</body>

</html>