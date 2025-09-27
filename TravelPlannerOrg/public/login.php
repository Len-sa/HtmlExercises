<?php
session_start();
include '../src/database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $database = new Database();
    $db = $database->connect();

    try {
        // Check if the username exists
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];  
            $_SESSION['first_name'] = 'Tola'; // TODO
            $_SESSION['last_name'] = 'Dhugaa'; // TODO
            header("Location: ./home.php");
            exit;
        } else {
              error_log("login is unsuccessful");
            $error = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $error = "Login failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/login.css">
</head>
<body>
  <div class="container">
    <nav>
      <h1 id="home-button">Triplore <h3 class="motto">Map it. Plan it. Live it</h3></h1>
      <div id="user-nav" style="display:flex;">
        <button id="logout-btn"><a href="main.html">Back</a></button>
      </div>
    </nav>

    <?php if (!empty($error)): ?>
      <p class="message-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="form" id="loginForm" method="POST" action="">
        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" required><br>

        <button class="login" type="submit">Login</button>
        <a href="signup.php" class="newUser">Don't have an account?</a>
    </form>
  </div>
</body>
</html>