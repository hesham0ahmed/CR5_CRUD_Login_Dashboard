<?php
session_start();
require_once "db_connect.php";


if (isset($_SESSION["adm"])) {
    header("Location: dashboard.php");
}

if (isset($_SESSION["user"])) {
    header("Location: home.php");
}

$email = $passError = $emailError = "";
$error = false;

function cleanInputs($input)
{
    $data = trim($input); // removing extra spaces, tabs, newlines out of the string
    $data = strip_tags($data); // removing tags from the string
    $data = htmlspecialchars($data); // converting special characters to HTML entities, something like "<" and ">", it will be replaced by "&lt;" and "&gt";

    return $data;
}

if (isset($_POST["login"])) {
    $email = cleanInputs($_POST["email"]);
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // if the provided text is not a format of an email, error will be true
        $error = true;
        $emailError = "Please enter a valid email address";
    }

    // simple validation for the "password"
    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty!";
    }

    if (!$error) {
        $password = hash("sha256", $password);

        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 1) {
            if ($row["status"] == "user") {
                $_SESSION["user"] = $row["id"];
                header("Location: home.php");
            } else {
                $_SESSION["adm"] = $row["id"];
                header("Location: dashboard.php");
            }
        } else {
            echo "<div class='alert alert-danger'>
                <p>Wrong credentials, please try again ...</p>
              </div>";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login page </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-black d-flex">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="login.php"><b>CR5 Pet Adoption</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    </li>

                    </li>
                    <li></li>

                </ul>
            </div>
        </div>
    </nav>
    <!--NAVBAR END-->

    <!-- LOGIN -->
    <div class="container1a">
        <form method="post" class="form1">
            <h2 id="heading1">Login</h2>
            <p class="text-center text-white">ADMIN: hello@hello.com / 123123</p>
            <p class="text-center text-white">User: hello2@hello.com / 123123</p>
            <div class="field1">
                <svg class="input-icon1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z"></path>
                </svg>

                <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>">
                <span class="text-danger"><?= $emailError ?></span>
            </div>
            <div class="field1">
                <svg class="input-icon1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                </svg>

                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                <span class="text-danger"><?= $passError ?></span>
            </div>
            <div class="btn1a">
                <button name="login" type="submit" class="button1a">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                <a href="register.php" class="button2a">Register Here </a>
                <!-- <button class="button2a">Sign Up</button> -->
            </div>

        </form>
    </div>
    <!-- LOGIN -->

    <!-- ADMIN LOGIN BUTTON -->




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>