<?php
include('connection/connection.php');

$errors = [];
$full_name_err = $email_err = $password_err = $retyped_password_err = $terms_checked = "";
$full_name = $email = $password = $retyped_password = $terms_unchecked = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["full_name"])) {
    $full_name_err = "Name is required";
    if (!preg_match("/^[a-zA-Z ]*$/", $full_name)) {
      $full_name_err = "Only letters and white space allowed";
    }
    $errors[] = $full_name_err;
  }

  if (empty($_POST["email"])) {
    $email_err = "Email is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
    }
    $errors[] = $email_err;
  }

  if (empty($_POST["password"])) {
    $password_err = "Please enter password!";
    if (($_POST["password"] != $_POST["retyped_password"])) {
      $password_err = "Please check You're Entered Or Confirmed Your Password!";
    }
    $errors[] = $password_err;
  }

  if (empty($_POST["terms"])) {
    $terms_unchecked = "You have to agree with our Terms to continue!";
    $errors[] = $terms_unchecked;
  }

  if (empty($errors)) {
    $full_name = test_input($_POST["full_name"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $retyped_password = test_input(($_POST["retyped_password"]));
    $terms_checked = test_input($_POST["terms"]);

    try {
      $sql = "INSERT INTO register_db (full_name, email, password) VALUES ('$full_name', '$email', '$password')";
      $conn->exec($sql);
      header("Location: dashbroad.php");
    } catch (PDOException $e) {
      echo $sql . "<br>" . $e->getMessage();
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
  <style>
    .error {
      color: #ff0000;
    }
  </style>

  <meta charset="utf-8">
  <title>Register</title>
  <link rel="stylesheet" type="text/css" href="css/register.css">
</head>

<body id="registerBody">
  <div class="registerBody">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
      <p>Register a new membership</p>
      <div class="registerInputContainer">
        <input placeholder="Full name" name="full_name" type="text">
        <span class="error"><?php echo $full_name_err; ?></span>

        <input placeholder="Email" name="email" type="text">
        <span class="error"><?php echo $email_err; ?></span>

        <input placeholder="Password" name="password" type="password">
        <span class="error"><?php echo $password_err; ?></span>

        <input placeholder="Retyped password" name="retyped_password" type="password">
        <span class="error"><?php echo $retyped_password_err; ?></span>
      </div>
      <div class="registerButtonContainer">
        <input type="checkbox" name="terms" value="checked">
        <label for="terms" style="margin:auto; padding-left:1px"> <strong>I agree to the <a href="#" style="text-decoration: none; color:dodgerblue">terms</a></strong> </label><br>
        <button style="background-color: #1877f2">Register</button>
      </div>
      <span class="error"> <?php echo $terms_unchecked; ?> </span>

      <p>- OR -</p>

      <div class="registerType">
        <button style="background-color: #1877f2">Sign up using FaceBook</button>
        <button style="background-color: #dc4234">Sign up using Google+</button>
      </div>
      <p style="text-align:start"><a href="Login.php" style="text-decoration: none; color:dodgerblue"> I already have a membership</a></p>
    </form>
  </div>
</body>

</html>