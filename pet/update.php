<?php
require_once "../db_connect.php";
require_once "../file_upload.php";


// 
session_start();

if (isset($_SESSION["user"])) {
    header("location: ../home.php");
}

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("location: ../login.php");
}
// 

$id = $_GET["id"]; // to take the value from the parameter "id" in the url 
$sql = "SELECT * FROM animal WHERE id = $id";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

$resultsize = mysqli_query($connect, "SELECT * FROM size");
$options = "";

while ($supRow = mysqli_fetch_assoc($resultsize)) {
    if ($row["fk_sizeId"] == $supRow["sizeId"]) {
        $options .= "<option selected value='{$supRow["sizeId"]}'>{$supRow["sizes"]}</option>";
    } else {
        $options .= "<option value='{$supRow["sizeId"]}'>{$supRow["sizes"]}</option>";
    }
}

if (isset($_POST["update"])) {

    $petname = $_POST['petname'];
    $age = $_POST["age"];
    $picture = fileUpload($_FILES["picture"], "product");
    $short_description = $_POST['short_description'];
    $big_description = $_POST['big_description'];
    $breed = $_POST['breed'];
    $locations = $_POST['locations'];
    $weights = $_POST['weights'];
    $species = $_POST['species'];
    $gender = $_POST['gender'];
    $price = $_POST['price'];
    $birth_date = $_POST['birth_date'];
    $size = $_POST["size"];
    $status = $_POST['status'];
    $vacc = $_POST['vacc'];

    /* checking if a picture has been selected  */
    if ($_FILES["picture"]["error"] == 0) {
        if ($row["picture"] != "product.png") {
            unlink("../pictures/$row[picture]");
        }

        $sql = "UPDATE animal SET petname = '$petname', picture = '$picture[0]', age = '$age', big_description = '$big_description', short_description = '$short_description', breed = '$breed', locations = '$locations', weights = '$weights', species = '$species', gender = '$gender', price = '$price', birth_date = '$birth_date', fk_sizeId = $size, status = '$status',vacc = '$vacc' WHERE id = {$id}";
    } else {
        $sql = "UPDATE animal SET petname = '$petname', age = '$age', big_description = '$big_description', short_description = '$short_description', breed = '$breed', locations = '$locations', weights = '$weights', species = '$species', gender = '$gender', price = '$price', birth_date = '$birth_date', fk_sizeId = $size, status = '$status',vacc = '$vacc' WHERE id = {$id}";
    }

    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-warning' role='alert'>
            Pet has been updated, {$picture[1]}
          </div>";
        header("refresh: 3; url= details.php?id={$row["id"]}");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            error found, {$picture[1]}
          </div>";
    }
}
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CR5 Pet Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-black d-flex">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="index.php"><b>CR5 Pet Adoption</b></a>
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
                    <li></li>
                    <li class="dashboard"><a class="btn3 nav-link text-white mx-3" href="../dashboard.php">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--NAVBAR END-->


    <div class="container mt-5">
        <h2>Update a <u>Existing</u> entry</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="petname" class="form-label">Petname</label>
                <input type="text" class="form-control" id="petname" aria-describedby="petname" name="petname" value="<?= $row["petname"] ?>">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">age</label>
                <input type="number" class="form-control" id="age" aria-describedby="age" name="age" value="<?= $row["age"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="short_description" class="form-label">Short Description</label>
                <input type="text" class="form-control" id="short_description" aria-describedby="short_description" name="short_description" value="<?= $row["short_description"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="big_description" class="form-label">Big Description</label>
                <input type="text" class="form-control" id="big_description" aria-describedby="big_description" name="big_description" value="<?= $row["big_description"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" class="form-control" id="breed" aria-describedby="breed" name="breed" value="<?= $row["breed"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="locations" class="form-label">Location</label>
                <input type="text" class="form-control" id="locations" aria-describedby="locations" name="locations" value="<?= $row["locations"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="weights" class="form-label">Weight</label>
                <input type="text" class="form-control" id="weights" aria-describedby="weights" name="weights" value="<?= $row["weights"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="species" class="form-label">Species</label>
                <input type="text" class="form-control" id="species" aria-describedby="species" name="species" value="<?= $row["species"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="gender" class="form-label">Gender</label>
                <input type="text" class="form-control" id="gender" aria-describedby="gender" name="gender" value="<?= $row["gender"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" aria-describedby="price" name="price" value="<?= $row["price"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="birth_date" class="form-label">Birth Date</label>
                <input type="date" class="form-control" id="birth_date" aria-describedby="birth_date" name="birth_date" value="<?= $row["birth_date"] ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">size</label>
                <select name="size" class="form-control">
                    <?= $options ?>
                </select>
            </div>

            <fieldset class="border border rounded p-3">
                <p><b>Is the Pet Adopted ?:</b></p>
                <div>
                    <input type="radio" id="here" name="status" value="0" <?= ($row["status"] == 0) ? "checked" : ""; ?> />
                    <label for="staus">Not Adopted</label>
                </div>
                <div>
                    <input type="radio" id="nothere" name="status" value="1" <?= ($row["status"] == 1) ? "checked" : ""; ?> />
                    <label for="staus">Adopted</label>
                </div>
            </fieldset>

            <fieldset class="border border rounded p-3 mt-3">
                <p><b>Vaccinated:</b></p>
                <div>
                    <input type="radio" id="notvacc" name="vacc" value="0" <?= ($row["vacc"] == 0) ? "checked" : ""; ?> />
                    <label for="staus">No</label>
                </div>
                <div>
                    <input type="radio" id="vacc" name="vacc" value="1" <?= ($row["vacc"] == 1) ? "checked" : ""; ?> />
                    <label for="staus">Yes</label>
                </div>
            </fieldset>
            <br>

            <div class="mb-3">
                <label for="picture" class="form-label">Pet Picture</label>
                <!-- Preview Picture -->
                <img src="../pictures/<?= $row["picture"] ?>" alt="user pic" width="75" height="75" class="mx-2 mb-3 rounded"> <!---->
                <input type="file" class="form-control" id="picture" aria-describedby="picture" name="picture">
            </div>

            <!-- <button name="update" type="submit" class="btn btn-primary">Update product</button> -->

            <button name="update" type="submit" style="background: linear-gradient(to bottom, #66a6ff  0%, #4dc7d9 100%);">
                <span>Update Pet</span>
            </button>

            <button name="button" style="background: linear-gradient(to bottom, #4dc7d9 0%, #66a6ff 100%)" ;>
                <a href="index.php" style="text-decoration: none; color:white;">Back Home</a>
            </button>
            <!-- <a href="index.php" class="btn btn-warning">Back to home page</a> -->
        </form>
    </div>
    <!-- FOOTER -->

    <section class="mt-4">
        <!-- Footer -->
        <footer class="text-center text-white" style="background-color: #0a4275;">
            <!-- Grid container -->
            <div class="container p-4 pb-0">
                <!-- Section: CTA -->
                <section class="">
                    <p class="d-flex justify-content-center align-items-center">
                        <span class="me-3">Register for free</span>
                        <button type="button" class="btn btn-outline-light btn-rounded">
                            Sign up!
                        </button>
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