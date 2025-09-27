<?php
include '../src/database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $country  = $_POST['country'];
    $password = $_POST['password'];

    $database = new Database();
    $db = $database->connect();

    try {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, country, password) 
                VALUES (:username, :email, :country, :password)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        header("Location:./home.php");
        exit;
    } catch (PDOException $e) {
        $error = "Signup failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
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

    <form class="form" id="signupForm" method="POST" action="">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Country:</label>
        <input type="text" name="country" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <label>Confirm Password:</label>
        <input type="password" name="confirmPassword" required>
        <div class="check">
            <input type="checkbox" name="subscribe" value="yes">Agree To terms and Conditions 
        </div>
        <button class="submit">Sign Up</button>
    </form>
    <script src="signup.js"></script>
  </div>
</body>
</html>