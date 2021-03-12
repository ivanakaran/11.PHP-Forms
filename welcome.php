<?php

require_once 'functions.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <title>Welcome Page</title>
</head>

<body>
  <div class="text-center top-marg">
    <?php
printSuccessMessage();
?>
  </div>
  <h1 class="text-center">Welcome <?php echo $_SESSION['username']; ?></h1>
</body>

</html>