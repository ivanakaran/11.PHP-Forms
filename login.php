<?php
require_once 'functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    checkLoginFields();

    loginUser();

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <title>Login</title>

</head>

<body>
  <div class="form-block">
    <div id="title">Login Form</div>
    <div class="body">
      <form action="" method="POST">
        <div>
          <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
          </div>
          <div>
            <label for="pass">Password:</label>
            <input type="password" name="password" id="pass">
          </div>
        </div>
        <button class="button">Login</button>
      </form>
    </div>
  </div>
  <div class="msg">
    <?php
printErrorMessage();
printInfoMessage();
?>
  </div>
</body>

</html>