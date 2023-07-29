<?php

session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
  header("Location: login.php");
}
if (isset($_SESSION["adm"])) {
  header("Location: dashboard.php");
}
// GET USER PICUTRE AND MORE
$sqlUser = "SELECT * FROM users WHERE id = {$_SESSION["user"]}";
$resultUser = mysqli_query($connect, $sqlUser);
$rowUser = mysqli_fetch_assoc($resultUser);

$adopt = 'd-none';
//GET WILL GET INFORMATION FROM TABLE animal -> column -> status = 0 (NOT ADOPTED) or 1 (ADOPTED)
if ($_GET['id']) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM animal WHERE id = {$id} and status = '0'";
  $result = mysqli_query($connect, $sql);

  // TOP IS CHECKING FOR ADOPTION
  // THIS IS FOR DETAILS
  // $sqlProducts = "SELECT * FROM animal";
  // $resultProducts = mysqli_query($connect, $sqlProducts);
  // DETAILS
  $layoutAdopt = "";
  if ((mysqli_num_rows($result) == 1)) { // CHECK IF PET IS 0 (NOT ADOPT & GET INFO)
    $row = mysqli_fetch_assoc($result);
    $petname = $row['petname'];
    $image = $row['picture'];
    $short_description = $row['short_description'];
    $big_description = $row['big_description'];
    $breed = $row['breed'];
    $locations = $row['locations'];
    $weights = $row['weights'];
    $species = $row['species'];
    $age = $row['age'];
    $gender = $row['gender'];
    $birth_date = $row['birth_date'];
    $price = $row['price'];
    $size = $row['fk_sizeId'];
    $statusLabel = ($row["status"] == 0) ? "Not Adopted" : "<span style='color: red;'>Adopted</span>";
    $vacc = ($row["vacc"] == 0) ? "No" : "<span style='color: red;'>Yes</span>";
    $layoutAdopt = "   
    <div class='container d-flex justify-content-center'><div class='card my-2 mx-2' style='width: 42rem;'>
    <img src='../pictures/$image' class='card-img-top cover' style='object-fit: cover; height: 20rem;' alt='img'>
  <div class='card-body'>
    <h5 class='card-title'><b>$petname</b></h5>
    <p class='card-text'>Overview: <b>$short_description</b></p>
  </div>
  <ul class='list-group list-group-flush'>
    <li class='list-group-item'>Age: <b>$age</b></li>
    <li class='list-group-item'>Description: <b>$big_description</b></li>
    <li class='list-group-item'>Breed: <b>$breed</b></li>
    <li class='list-group-item'>Locations: <b>$locations</b> </li>
    
    <li class='list-group-item'>
    Species: <a href='species_user.php?species=$species'>$species</a>
    <li class='list-group-item'>Gender: <b>$gender</b></li>
    <li class='list-group-item'>Birth Date: <b>$birth_date</b></li>
    <li class='list-group-item'>Size: <b>$size</b></li>
    <li class='list-group-item'>Status: <b>$statusLabel</b></li>
    <li class='list-group-item'>Vaccinated: <b>$vacc</b></li>
    <li class='list-group-item'>Price: <b>$price$</b></li>
<div class='but'>
   
    <a href='home.php' class='button3 my-2' style='border: solid blue 2px;'>Go Back</a>
     <form method='post'>
  <input type='hidden' name='id' value='" . $id . "' />
  <input type='hidden' name='picture' value='" . $image . "' />
  <button class='button3 my-2 mx-2' style='border: solid orange 2px; type='submit'>Adopt ME !</button>
  </ul>
 
</div>
</div>";
  } elseif (mysqli_num_rows($result) == 0) { // pet not found or already adopted
    $layoutAdopt = "<h3 class='text-center m-5'>I am currently not available for adoption, I have a Beautiful Home now!</h3>
    <div class='but mb-5'><img src='/pictures/ado.webp' alt='' srcset='' height=300px></div>
    <div class='container text-center'><a href='home.php'><button class='btn btn-secondary' type='button'>OK, go back!</button></a></div>
    ";
  }
}


//the POST method will put the "Adopted" status on the pet and insert date and ids to pet_adoption.
if ($_POST) {
  $id = $_POST['id'];

  $sql = "UPDATE `animal` SET `status`='1' WHERE id = {$id}";
  $sqlAdopt = "INSERT INTO `pet_adopt`(`adopt_date`, `fk_userID`, `fk_animalID`) VALUES (now(), $_SESSION[user], $id)";

  if ($connect->query($sql) === TRUE && $connect->query($sqlAdopt) === TRUE) {
    $adopt = "alert alert-success";
    $message = "You Successfully Adopted a PET! Read our AGB for more Information about PET adopting";
    header("refresh:3;url=home.php");
  } else {
    $adopt = "alert alert-danger";
    $message = "The pet was not adopted due to: <br>" . $connect->error;
    header("refresh:3;url=home.php");
  }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adopt A Pet</title>

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

            <a class="nav-link text-white btn3" href="myadopt.php">My Adoptions</a>

            </a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link text-white btn4" href="senior.php">Senior PETS</a>
            </a>
          </li>
          <li></li>

          <li class="nav-item mx-2">
            <a class="nav-link text-white btn4" href="home.php">All PETS</a>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white btn3 mx-2" href="logout.php?logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--NAVBAR END-->
  <div class="<?php echo $adopt; ?>" role="alert">
    <p><?php echo ($message) ?? ''; ?></p>
  </div>
  <?= $layoutAdopt ?>
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