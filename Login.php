<?php
include('connection/connection.php');


$errors = [];
$email_err = $password_err = "";
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["email"])) {
    $email_err = "Email is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
    }
    $errors[] = $email_err;
  }

  if (empty($_POST["password"])) {
    $password_err = "Please enter password!";
    $errors[] = $password_err;
  }

  if (empty($errors)) {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);

    try {

      $stmt = $conn->prepare("SELECT * FROM register_db WHERE email = :email");
      $stmt->bindValue(':email', $email);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);


      $stmt = $conn->prepare("SELECT * FROM register_db WHERE email = :email AND `password` = :password");
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', $password);


      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {
        header("Location: dashbroad.php");
      } else {
        echo "Failure !";
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body id="loginBody">
  <div class="loginBody">
    <form action="Login.php" method="post">
      <p>Sign in to start your session</p>
      <div class="loginInputContainer">
        <input placeholder="Email" name="email" type="text">
      </div>
      <div class="loginInputContainer">
        <input placeholder="Password" name="password" type="password">
      </div>
      <div class="loginButtonContainer">
        <input type="checkbox" name="RememberMe" value="checked">
        <label for="RememberMe" style="margin:auto; padding-left:1px"> <strong>Remember Me</strong> </label><br>
        <button style="background-color: #1877f2" onclick="location.href='dashbroad.php';">Sign in</button>

      </div>

      <p>- OR -</p>
      <div class="loginType">
        <button style="background-color: #1877f2">Sign ip using FaceBook</button>
        <button style="background-color: #dc4234">Sign ip using Google+</button>
      </div>
      <p style="text-align:start"><a href="Forget_password.php" style="text-decoration: none; color:dodgerblue">I forgot my password</a></p>
      <p style="text-align:start"><a href="Register.php" style="text-decoration: none; color:dodgerblue"> Register a new membership</a></p>
    </form>
  </div>
</body>

</html>