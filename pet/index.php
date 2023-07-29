<?php

require_once "../db_connect.php";

session_start();

if (isset($_SESSION["user"])) {
    header("location: ../home.php");
} // IF IAM A USER -> REDIRECT TO home.php

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("location: ../login.php");
} // IF IAM A USER or ADMIN -> REDIRECT TO login.php

// $sql = "SELECT * FROM `products`"; // QUERY; SELECT ALL FROM DB phpmyadmin // ITS LIKE THE OK BUTTON IN phpmyadmin

// TEST
// QUERY FETCH DATA FROM ANIMAL
$sqlProducts = "SELECT * FROM `animal`";
$resultProducts = mysqli_query($connect, $sqlProducts);


// QUERY TO FETCH USER DATA BASED IN THE LOGGED-IN ADMIN-ID
$sqlUser = "SELECT * FROM users WHERE id = {$_SESSION["adm"]}";
$resultUser = mysqli_query($connect, $sqlUser);

// FETCHING THE USER DATA INTO $userRow
$userRow = mysqli_fetch_assoc($resultUser);
// TEST

// $result = mysqli_query($connect, $sql); // FOR THE CONNECTION OF SQL

//var_dump($result); // SHOWS ME THE TYPE AND VARIABLE

$layout = "";



// TO CHECK IF I GOT PRODUCTS TO SHOWN OR IN MY DB (num_rows) to see in var_dump($result) output
if (mysqli_num_rows($resultProducts) > 0) {
    while ($row = mysqli_fetch_assoc($resultProducts)) {
        $statusLabel = ($row["status"] == 0) ? "Not Adopted" : "<span style='color: red;'>Adopted</span>";
        $vacc = ($row["vacc"] == 0) ? "No" : "<span style='color: red;'>Yes</span>";
        $layout .= "  
    <div class='container'>
    <div>
    <div class='card my-2 mx-2' style='width: auto;'>
    <img src='../pictures/{$row["picture"]}' class='card-img-top my-2' alt='...'>
    <a href='delete.php?id={$row["id"]}'><span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'>
    X
      </span></a>
    <div class='card-body'>
      <h5 class='card-title'>{$row["petname"]}</h5>
      <p class='card-text'>{$row["short_description"]}</p>
    </div>
    <div class='but'>
        <a href='details.php?id={$row["id"]}' class='button2'>Show details</a>
    </div>
    <ul class='list-group list-group-flush'>
      <li class='list-group-item'>Age: {$row["age"]}</li>
      <li class='list-group-item'>Status: <b>{$statusLabel}</b></li>
      <li class='list-group-item'>Vaccinated: <b>{$vacc}</b></li>
      <li class='list-group-item'>
    Species: <a href='species.php?species={$row["species"]}'>{$row["species"]}</a>
</li>
    </ul>
    </div>
  </div>
  </div>"; // .= is the same like +=
    }
} else {
    $layout .= "<h4>No Result or No Pets</h4>"; // NO PRODUCTS THEN THIS IS THE OUTPUT
}
// CONVERT FORM SQL TO SHOW IN HTTP / PHP

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CR5 Pet Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-black d-flex">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="index.php"><b>CR5 Pet Adoption</b></a>
            <img src="../pictures/<?= $userRow["picture"] ?>" alt="user pic" width="40" height="40" class="mx-2">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    </li>
                    <li class="nav-item">

                        <a type="button" class="additem" href="create.php">
                            <span class="additem_text">Add Pet</span>
                            <span class="additem_icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg">
                                    <line y2="19" y1="5" x2="12" x1="12"></line>
                                    <line y2="12" y1="12" x2="19" x1="5"></line>
                                </svg></span>
                        </a>
                    </li>

                    <li class="dashboard"><a class="btn3 nav-link text-white mx-3" href="../dashboard.php">Dashboard</a></li>
                    <li class="nav-item">
                        <a class="nav-link text-white btn3 " href="../logout.php?logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--NAVBAR END-->
    <div class="my-3 alert">
        <h4 class="text-center">Youre an Administrator, <?= $userRow["first_name"] . " " . $userRow["last_name"] ?></h4>
        <p class="text-center">** you have the rights to CRUD -> Users / Pets ! **</p>
    </div>
    <!-- SLIDER -->
    <div id="carouselExampleAutoplaying" class="carousel slide mb-3" data-bs-ride="carousel">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../pictures/l1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 style="text-shadow: 2px 2px 3px black;">CR5 - Pet Adoption</h1>

                    <p style="letter-spacing: 2px; text-shadow: 2px 2px 3px black;">
                        CRUD</p>

                </div>
            </div>
            <div class="carousel-item">
                <img src="../pictures/l2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 style="text-shadow: 2px 2px 3px black;">CREATE - READ - UPDATE - DELETE</h1>
                    <p style="letter-spacing: 2px; text-shadow: 2px 2px 3px black;">The Choice is in your Hand</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- SLIDER -->
    <div class="container">
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-1">


            <?= $layout ?> <!-- SHORT FOR ?php echo-->
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