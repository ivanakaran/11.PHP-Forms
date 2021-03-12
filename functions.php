<?php

function checkSignUpFields()
{
    if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
        header("Location: signup.php?danger=required");
        die();
    }
}

function checkLoginFields()
{
    if (empty($_POST['username']) || empty($_POST['password'])) {
        header("Location: login.php?danger=required");
        die();
    }
}

function isUsernameValid()
{
    if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['username'])) {
        header("Location: signup.php?danger=notvalidusername");
        die();
    }
}

function isEmailValid()
{
    if (!preg_match("/^(?=[^@]{5,}@)([\w\.-]*[a-zA-Z0-9_]@(?=.{4,}\.[^.]*$)[\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z])$/", strtolower($_POST['email']))) {
        header("Location: signup.php?danger=notvalidemail");
        die();
    }
}

function isPasswordValid()
{
    if (!preg_match("/(?=.*?[0-9])(?=.*[A-Z])(?=.*[!\{\}@;:<>~`\\.,'\"#\$%\^&\+\_\-\/\|\[\]\=?()\*\s])/", $_POST['password'])) {
        header("Location: signup.php?danger=notvalidpassword");
        die();
    }
}

function isUsernameTaken()
{

    $allusers = file_get_contents("users.txt");
    $allusers = explode("\n", $allusers);
    foreach ($allusers as $user) {
        $user = preg_split('/[,=]/', $user, 3);
        if ($user[1] == $_POST['username']) {
            $_SESSION['password'] = $user[2];
            header("Location: signup.php?info=usernametaken");
            die();
        }
    }
}

function isEmailTaken()
{
    $allusers = file_get_contents("users.txt");
    $allusers = explode("\n", $allusers);

    foreach ($allusers as $user) {
        $user = preg_split('/[,=]/', $user, 3);
        if ($user[0] == strtolower($_POST['email'])) {
            $_SESSION['password'] = $user[2];
            header("Location: signup.php?info=emailfound");
            die();
        }
    }
}

function loginUser()
{
    $allusers = file_get_contents("users.txt");
    $allusers = explode("\n", $allusers);

    foreach ($allusers as $user) {
        $user = preg_split('/[,=]/', $user, 3);
        if ($user[1] == $_POST['username'] && $user[2] == $_POST['password']) {
            $_SESSION['username'] = $_POST['username'];
            header("Location: welcome.php?success=loggedin");
            die();
        }
    }
    header("Location: login.php?danger=usernotfound");
    die();
}

function signUpUser()
{
    if (file_put_contents("users.txt", strtolower($_POST['email']) . "," . $_POST['username'] . "=" . $_POST['password'] . "\n", FILE_APPEND)) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: welcome.php?success=signup");
        die();
    } else {
        header("Location: signup.php?danger=general");
        die();
    }
}

function printErrorMessage()
{
    if (isset($_GET['danger'])) {
        $dangerMessages = [
            'notvalidusername' => "The username does not meet all requirements.",
            'notvalidemail' => "The email does not meet all requirements. It must have at least 5 characters before @",
            'notvalidpassword' => "Password must have at least one number, one special sign and one uppercase
            letter!",
            'required' => "All fields are required.",
            'usernametaken' => "Username already exists.",
            'usernotfound' => "Wrong username /
            password combination.",
            'general' => "An error occurred, please try again later.",
        ];

        if (isset($dangerMessages[$_GET['danger']])) {
            echo "<span class='red-alert'>" . $dangerMessages[$_GET['danger']] . "</span><br><a href = 'index.php' class = 'button'>Back to home page</a>";
        }
    }
}

function printInfoMessage()
{
    if (isset($_GET['info'])) {
        $infoMessages = [
            'required' => "All fields are required!",
            'usernametaken' => "User with that username already exists.",
            'usernotfound' => "Wrong username /
            password combination.",
            'emailfound' => "‘You are already registered – your
            password is {$_SESSION['password']}.",
        ];

        if (isset($infoMessages[$_GET['info']])) {
            echo "<span class='yellow'>" . $infoMessages[$_GET['info']] . "</span><br><a href = 'index.php' class = 'button' >Back to home page</a>";
        }
    }
}

function printSuccessMessage()
{
    if (isset($_GET['success'])) {
        $successMessages = [
            'loggedin' => "You have logged in successfully.",
            'signup' => "You have signed up successfully.",
        ];

        if (isset($successMessages[$_GET['success']])) {
            echo "<span class='green'>" . $successMessages[$_GET['success']] . "</span>";
        }
    }
}