<!DOCTYPE html>
<html>
<head>
  <title>Register - User Sale Game Account</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
  <h1>Register</h1>
  <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Connect to the database
      $conn = new mysqli('localhost', 'root', '', 'salegameaccount');
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Retrieve the user's details from the database
      $username = $_POST['username'];
      $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->fetch_assoc();
      $stmt->close();

      // Check if the password is correct
      $password = $_POST['password'];
      if ($user && password_verify($password, $user['password'])) {
        // Passwords match, log the user in
        echo "Login successful!";
      } else {
        // Passwords don't match, show an error message
        echo "Invalid username or password.";
      }

      // Close the database connection
      $conn->close();
    }
  ?>
  <form method="POST" action="">
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <input type="submit" value="Login">
  </form>
</body>
</html>
