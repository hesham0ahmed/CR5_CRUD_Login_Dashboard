<?php

session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
  header("Location: login.php");
}
if (isset($_SESSION["adm"])) {
  header("Location: dashboard.php");
}

$sqlUser = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
$resultUser = mysqli_query($connect, $sqlUser);
$rowUser = mysqli_fetch_assoc($resultUser);

if (isset($_SESSION['adoptedAnimalIDs'])) {
  $adoptedAnimalIDs = $_SESSION['adoptedAnimalIDs'];
} else {
  $adoptedAnimalIDs = []; // Default empty array if the session variable is not set
}

// Get the user's adopted pets from the pet_adopt table
$userId = $_SESSION['user'];
$sql = "SELECT animal.*, size.sizes
        FROM animal
        LEFT JOIN size ON animal.fk_sizeId = size.sizeId
        INNER JOIN pet_adopt ON animal.id = pet_adopt.fk_animalID
        WHERE pet_adopt.fk_userID = {$userId}";

$result = mysqli_query($connect, $sql);

// Display the adopted pets
$layoutMyAdopt = '';
if (mysqli_num_rows($result) > 0) {
  $layoutMyAdopt .= '';
  while ($row = mysqli_fetch_assoc($result)) {
    $petname = $row['petname'];
    $productImage = $row['picture'];
    // ... (other pet details as needed)

    $layoutMyAdopt .= "
    
    <div class='row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-1'>
    <div>
      <div class='card my-2 mx-2' style='width:20rem'>
        <img src='pictures/$productImage' class='card-img-top cover' style='object-fit: cover; height: 20rem;' alt='img'>
        <div class='card-body'>
          <h5 class='card-title'><b>$petname</b></h5>
         
        </div>
        </div> </div> </div> 
    ";
  }
  $layoutMyAdopt .= '</div>';
} else {
  $layoutMyAdopt = "<h3 class='text-center m-5'>You have not adopted any pets yet!</h3>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Adopted Pets</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-black ">
    <div class="container-fluid">
      <a class="navbar-brand text-white" href="home.php"><b>CR5 Pet Adoption</b></a>
      <img src="pictures/<?= $rowUser["picture"] ?>" alt="user pic" width="40" height="40" class="mx-2">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
          </li>
          <li class="nav-item mx-2">

            <a class="nav-link text-white btn4" href="home.php">All PETS</a>

            </a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link text-white btn4" href="senior.php">Senior PETS</a>
            </a>
          </li>
          <li></li>


          <li class="nav-item">
            <a class="nav-link text-white btn3 mx-2" href="logout.php?logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--NAVBAR END-->


  <h1 class="text-center my-4">My Adopted Pets</h1>
  <p class="text-center"> To Unadopt a PET please contact the ADMIN</p>

  <!-- Use the desired layout classes here -->
  <div class="container">
    <div class="  d-flex justify-content-center">
      <?= $layoutMyAdopt ?>
    </div>
  </div>

  <div class="container text-center">
    <a href="home.php" class="btn3 p-1" type="button">Back to Home>

    </a>
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
</body>

</html>