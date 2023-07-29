<?php
require_once "../db_connect.php";
require_once "../file_upload.php";

// CRUD LOGIN

session_start();

if (isset($_SESSION["user"])) {
    header("location: ../home.php");
}

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("location: ../login.php");
}

$result = mysqli_query($connect, "SELECT * FROM size");

$options = "";

while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='{$row["sizeId"]}'>{$row["sizes"]}</option>"; // DROPDOWN FOR SIZE on NEW TABLE size
}

if (isset($_POST["create"])) {
    $size = isset($_POST["size"]); // ? $_POST["size"] : null;
    // CRUD LOGIN


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
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $vacc = isset($_POST['vacc']) ? $_POST['vacc'] : '';
    $birth_date = $_POST['birth_date'];



    $sql = "INSERT INTO animal (`petname`, `picture`, `age`, `big_description`, `short_description`, `breed`, `locations`, `weights`, `species`, `gender`, `price`, `birth_date`, `status`, `vacc`, `fk_sizeId`) VALUES ('$petname','{$picture[0]}','$age', '$big_description', '$short_description',  '$breed', '$locations', '$weights', '$species', '$gender','$price', '$birth_date', '$status', '$vacc','$size')";


    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
                New record has been created, {$picture[1]}
              </div>";
        header("refresh: 3; url=index.php");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
                Error found: " . mysqli_error($connect) . "
              </div>";
    }
}
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
        <div class="code-loader">
            <div>{Create a Pet Adoption entry}
            </div>
        </div>
        <form method="POST" enctype="multipart/form-data" class="form">
            <div class="mb-3 mt-3">
                <label for="petname" class="form-label">Petname</label>
                <input type="text" class="form-control" id="petname" aria-describedby="petname" name="petname">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" aria-describedby="age" name="age">
            </div>
            <div class="mb-3 mt-3">
                <label for="short_description" class="form-label">Short Description</label>
                <input type="text" class="form-control" id="short_description" aria-describedby="short_description" name="short_description" placeholder="max. 200 Characters">
            </div>
            <div class="mb-3 mt-3">
                <label for="big_description" class="form-label">Big Description</label>
                <input type="text" class="form-control" id="big_description" aria-describedby="big_description" name="big_description" placeholder="max. 400 Characters">
            </div>
            <div class="mb-3 mt-3">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" class="form-control" id="breed" aria-describedby="breed" name="breed">
            </div>
            <div class="mb-3 mt-3">
                <label for="locations" class="form-label">Location</label>
                <input type="text" class="form-control" id="locations" aria-describedby="locations" name="locations">
            </div>
            <div class="mb-3 mt-3">
                <label for="weights" class="form-label">Weight</label>
                <input type="text" class="form-control" id="weights" aria-describedby="weights" name="weights">
            </div>
            <div class="mb-3 mt-3">
                <label for="species" class="form-label">Species</label>
                <input type="text" class="form-control" id="species" aria-describedby="species" name="species">
            </div>
            <div class="mb-3 mt-3">
                <label for="gender" class="form-label">Gender</label>
                <input type="text" class="form-control" id="gender" aria-describedby="gender" name="gender">
            </div>
            <div class="mb-3 mt-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" aria-describedby="price" name="price">
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">size</label>

                <select name="size" class="form-control">
                    <option value="null" selected> ... </option>
                    <?= $options ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="birth_date" class="form-label">Birth Date</label>
                <input type="date" class="form-control" id="birth_date" aria-describedby="birth_date" name="birth_date">
            </div>


            <fieldset class="border border rounded p-3">
                <p><b>Is the Pet Adopted ?</b></p>
                <div>
                    <input type="radio" id="here" name="status" value="0" />
                    <label for="staus">Not Adopted</label>
                </div>
                <div>
                    <input type="radio" id="nothere" name="status" value="1" />
                    <label for="staus">Adopted</label>
                </div>
            </fieldset>

            <fieldset class="border border rounded p-3 mt-3">
                <p><b>Vaccinated:</b></p>
                <div>
                    <input type="radio" id="notvacc" name="vacc" value="0" />
                    <label for="vacc">No</label>
                </div>
                <div>
                    <input type="radio" id="vacc" name="vacc" value="1" />
                    <label for="vacc">Yes</label>
                </div>
            </fieldset>

            <div class="mb-3">
                <label for="picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="picture" aria-describedby="picture" name="picture">
            </div>

            <!-- <button name="create" type="submit" class="btn btn-primary">Create product</button> -->

            <button name="create" type="submit" style="background: linear-gradient(to bottom, #66a6ff  0%, #4dc7d9 100%);">
                <span>Create Pet</span>
            </button>

            <button name="button" style="background: linear-gradient(to bottom, #4dc7d9 0%, #66a6ff 100%)" ;>
                <a href="index.php" style="text-decoration: none; color:white;">Back Home</a>
            </button>

            <!-- <a href="index.php" class="btn btn-warning">Back Home</a> -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>