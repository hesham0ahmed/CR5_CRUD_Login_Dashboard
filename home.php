<?php

session_start();
require_once "db_connect.php";

if (isset($_SESSION["adm"])) {
    header("Location: dashboard.php");
}  // IF IAM A ADMIN -> REDIRECT TO dashboard.php

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
} // IF IAM A USER or ADMIN -> REDIRECT TO login.php

$sql = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
$sqlProducts = "SELECT * FROM animal";
$resultProducts = mysqli_query($connect, $sqlProducts);

$layout = "";

// TO CHECK IF I GOT PRODUCTS TO SHOWN OR IN MY DB (num_rows) to see in var_dump($result) output
if (mysqli_num_rows($result) > 0) {
    while ($rowProduct = mysqli_fetch_assoc($resultProducts)) {
        $statusLabel = ($rowProduct["status"] == 0) ? "Not Adopted" : "<span style='color: red;'>Adopted</span>";
        $layout .= "  
        <div class='container'>
             <div>
       <div class='card my-2 mx-2' style='width: auto;'>
    <img src='pictures/{$rowProduct["picture"]}' class='card-img-top my-2' alt='...'>
        <div class='card-body'>
      <h5 class='card-title'>{$rowProduct["petname"]}</h5>
      <p class='card-text'>{$rowProduct["short_description"]}</p>
    </div>
        <div class='but'><a href='adopt.php?id=" . $rowProduct['id'] . "'class='button4 mx-3'>
    <strong>ADOPT ME</strong>
    <div id='container-stars'>
      <div id='stars'></div>
    </div>
      <div id='glow'>
      <div class='circle'></div>
      <div class='circle'></div>
    </div>
    </a></div>
<hr>
    <div class='but'>
        <a href='pet/details_user.php?id={$rowProduct["id"]}' class='button7 mx-2'>DETAILS
        <svg class='empty' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='32' height='32'><path fill='none' d='M0 0H24V24H0z'></path><path d='M16.5 3C19.538 3 22 5.5 22 9c0 7-7.5 11-10 12.5C9.5 20 2 16 2 9c0-3.5 2.5-6 5.5-6C9.36 3 11 4 12 5c1-1 2.64-2 4.5-2zm-3.566 15.604c.881-.556 1.676-1.109 2.42-1.701C18.335 14.533 20 11.943 20 9c0-2.36-1.537-4-3.5-4-1.076 0-2.24.57-3.086 1.414L12 7.828l-1.414-1.414C9.74 5.57 8.576 5 7.5 5 5.56 5 4 6.656 4 9c0 2.944 1.666 5.533 4.645 7.903.745.592 1.54 1.145 2.421 1.7.299.189.595.37.934.572.339-.202.635-.383.934-.571z'></path></svg>
  <svg class='filled' height='32' width='32' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'><path d='M0 0H24V24H0z' fill='none'></path><path d='M16.5 3C19.538 3 22 5.5 22 9c0 7-7.5 11-10 12.5C9.5 20 2 16 2 9c0-3.5 2.5-6 5.5-6C9.36 3 11 4 12 5c1-1 2.64-2 4.5-2z'></path></svg>
        </a>
           </div>
    <ul class='list-group list-group-flush'>
      <li class='list-group-item'>Age: {$rowProduct["age"]}</li>
      <li class='list-group-item'>Status: <b>{$statusLabel}</b></li>
           <li class='list-group-item'>
    Species: <a href='pet/species_user.php?species={$rowProduct["species"]}'>{$rowProduct["species"]}</a>
</li>
    </ul>
    </div>
  </div>
  </div>"; // .= is the same like +=
    }
} else {
    $layout .= "<h4>No Result or No Pets</h4>"; // NO PRODUCTS THEN THIS IS THE OUTPUT
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?= $row["first_name"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-black ">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="home.php"><b>CR5 Pet Adoption</b></a>
            <img src="pictures/<?= $row["picture"] ?>" alt="user pic" width="40" height="40" class="mx-2">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white btn3" href="myadopt.php">My Adoptions</a>

                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-white btn4" href="senior.php">Senior PETS</a>

                    </li>
                    <li></li>
                    <li class="nav-item">
                        <a class="nav-link text-white btn3 mx-2" href="update.php?id=<?= $row["id"] ?>">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white btn3 mx-2" href="logout.php?logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--NAVBAR END-->
    <h6 class="mx-3 my-3">Welcome " <?= $row["first_name"] . " " . $row["last_name"] ?> "</h6>

    <div class="container">
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-1">

            <?= $layout ?>
        </div>
    </div>

    <!-- FOOTER -->

    <section class="mt-4">
        <!-- Footer -->
        <footer class="text-center text-white" style="background-color: #0a4275;">
            <!-- Grid container -->
            <div class="container p-1 pb-0">
                <!-- Section: CTA -->
                <section class="">
                    <p class="d-flex justify-content-center align-items-center">

                    <ul class="nav justify-content-center d-flex">
                        <li class="ms-3"><i class="bi bi-twitter"></i></li>
                        <li class="ms-3"><i class="bi bi-facebook"></i></li>
                        <li class="ms-3"><i class="bi bi-instagram"></i></li>
                        <li class="ms-3"><i class="bi bi-youtube"></i></li>
                    </ul>
                    </p>
                </section>
                <!-- Section: CTA -->
            </div>
            <!-- Grid container -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © 2023 Copyright:
                <a class="text-white" href="index.php">CodeFactory</a>
            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>