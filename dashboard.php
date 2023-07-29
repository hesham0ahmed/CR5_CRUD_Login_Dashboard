<?php

session_start();

if (isset($_SESSION["user"])) {
    header("Location: home.php");
} // IF IAM A USER -> REDIRECT TO home.php

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
} // IF IAM A USER or ADMIN -> REDIRECT TO login.php

require_once "db_connect.php";

/* ======== BEGIN OF USER DATA ======== */

$sql = "SELECT * FROM users WHERE id = {$_SESSION["adm"]}"; // SELECT ALL DATA AND QUERY FETCH 
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
$sqlUsers = "SELECT * FROM users WHERE status != 'adm'";
$resultUsers = mysqli_query($connect, $sqlUsers);
$layout = "";

if (mysqli_num_rows($resultUsers) > 0) {
    while ($userRow = mysqli_fetch_assoc($resultUsers)) {
        // GET THE ADOPTED PETS FOR THE USER
        $adoptedAnimalIDs = array(); // STORE FOR ADOPTED PET IDs
        $sqlAdoptedPets = "SELECT fk_animalID FROM pet_adopt WHERE fk_userID = {$userRow['id']}";
        $resultAdoptedPets = mysqli_query($connect, $sqlAdoptedPets);
        while ($rowAdoptedPet = mysqli_fetch_assoc($resultAdoptedPets)) {
            $adoptedAnimalIDs[] = $rowAdoptedPet['fk_animalID']; // ADOPTED_iD INTO ARRAY
        }

        $layout .= "
            <tr> 
                <td>{$userRow['id']}</td>
                <td><img class='img-thumbnail' width='60' height='60' src='pictures/{$userRow["picture"]}'></td>
                <td class='fName'>{$userRow['first_name']}</td>
                <td class='lName'>{$userRow['last_name']}</td>
                <td class='emailtha'>{$userRow['email']}</td>";

        // TO SEE THE ADOPTED PET FOR THIS USER
        $layout .= "<td>";
        foreach ($adoptedAnimalIDs as $animalID) {
            $layout .= "<p>ID: {$animalID}</p>";
        }
        $layout .= "</td>";

        $layout .= "
            <td><a href='update.php?id={$userRow["id"]}' class='btn btn-outline-warning btn-rounded text-black'>Update User</a></td>
            <td><a href='deleteUser.php?id={$userRow["id"]}' class='btn btn-danger btn-rounded'>Delete User</a></td>
        </tr> ";
    }
} else {
    $layout .= "No results found!";
}

/* ======== END OF USER DATA ======== */

/* ======== BEGIN OF ANIMAL DATA ======== */

$sqlProducts = "SELECT * FROM `animal`";
$resultProducts = mysqli_query($connect, $sqlProducts);
$sqlUser = "SELECT * FROM users WHERE id = {$_SESSION["adm"]}";
$resultUser = mysqli_query($connect, $sqlUser);
$userRows = null;
if ($resultUser) {
    $userRows = mysqli_fetch_assoc($resultUser);
} else {
    // SPACE FOR AN ERROR IF CANT LOAD
}

$layoutProducts = "";

if (mysqli_num_rows($resultProducts) > 0) {
    while ($rows = mysqli_fetch_assoc($resultProducts)) {
        $statusLabel = ($rows["status"] == 0) ? "Not Adopted" : "<span style='color: red;'>Adopted</span>";
        $vacc = ($rows["vacc"] == 0) ? "No" : "<span style='color: red;'>Yes</span>";

        // GET THE USERiD WITH ADOPTED PET
        $adoptedByUserIDs = array();
        $sqlAdoptedByUsers = "SELECT fk_userID FROM pet_adopt WHERE fk_animalID = {$rows['id']}";
        $resultAdoptedByUsers = mysqli_query($connect, $sqlAdoptedByUsers);
        while ($rowAdoptedByUser = mysqli_fetch_assoc($resultAdoptedByUsers)) {
            $adoptedByUserIDs[] = $rowAdoptedByUser['fk_userID'];
        }

        $layoutProducts .=
            "<tr> 
        <td>{$rows['id']}</td>
        <td><img class='img-thumbnail' width='60' height='60' src='pictures/{$rows["picture"]}'></td>
        <td class='titleRow'>{$rows['petname']}</td>
        <td class='isbn'>{$rows['age']}</td>
       
        
        <td class='usedP'>{$vacc}</td>";

        // TO SEE THE USERiD WHO ADOPTED THIS PET
        $layoutProducts .= "<td>";
        foreach ($adoptedByUserIDs as $userID) {
            $layoutProducts .= "<p>userID: {$userID}</p>";
        }
        $layoutProducts .= "</td>";

        if ($rows['status'] == 1) {
            // If the pet is adopted, show the "Unadopt" button
            $layoutProducts .= "<td>";
            if (!empty($adoptedByUserIDs)) {
                // Get the first user who adopted the pet
                $userID = $adoptedByUserIDs[0];
                $layoutProducts .= "
                    <form method='post' action='unadopt.php' onsubmit=\"return confirm('Are you sure you want to unadopt this pet?')\">
                        <input type='hidden' name='pet_id' value='{$rows['id']}' />
                        <input type='hidden' name='user_id' value='{$userID}' />
                        <button type='submit' class='btn btn-danger'>Unadopt</button>
                    </form>";
            } else {
                $layoutProducts .= "No User ID"; // Placeholder message if no user has adopted the pet
            }
            $layoutProducts .= "</td>";
        } else {
            // If the pet is not adopted, display an empty cell and update the status to "Not Adopted" in the table
            $layoutProducts .= "<td>Not Adopted</td>";
            $sqlUpdateStatus = "UPDATE animal SET status = 0 WHERE id = {$rows['id']}";
            mysqli_query($connect, $sqlUpdateStatus);
        }


        $layoutProducts .= "
        <td> <a href='pet/update.php?id={$rows["id"]}' class='btn btn-outline-warning btn-rounded text-black'>Update Pet</a></td>
        <td><a href='pet/delete.php?id={$rows["id"]}' class='btn btn-danger btn-rounded'>Delete Pet</a></td>
   </tr> ";
    }
} else {
    $layoutProducts .= "No results found!";
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
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-black ">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="dashboard.php"><b>CR5 Dashboard</b></a>
            <img src="pictures/<?= $row["picture"] ?>" alt="user pic" width="40" height="40" class="mx-2">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    </li>
                    <li></li>
                    <li class="nav-item">
                        <a class="nav-link text-white btn4 mx-2" aria-current="page" href="pet/index.php">PETS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white btn3 mx-2" href="update.php?id=<?= $row["id"] ?>">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white btn3 mx-2" href="registerAdmin.php">Create User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white btn3 mx-2" href="logout.php?logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!--NAVBAR END-->
    <div class="my-3 alert">
        <h4 class="text-center">Youre an Administrator, <?= $row["first_name"] . " " . $row["last_name"] ?></h4>
        <p class="text-center">** you have the rights to CRUD -> Users / Pets ! **</p>
    </div>
    <!-- TABLE USERS -->
    <div class=" bg-danger bg-opacity-10">
        <hr>
        <h2 class="text-center">TABLE USER</h2>
        <hr>
    </div>
    <div class="table1 border-top border-bottom border-5 rounded-top rounded-bottom border-warning">
        <table class="table table-striped text-center table-responsive-md">
            <thead>
                <tr>
                    <th scope="col">ID #</th>
                    <th scope="col" class="img-thumbnail">Picture</th>
                    <th scope="col" class="fName">Firstname</th>
                    <th scope="col" class="lName">Lastname</th>
                    <th scope="col" class="emailth">Email</th>
                    <th scope="col" class="usst">Adopted</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?= $layout; ?>
            </tbody>
        </table>
    </div>

    <!-- TABLE END -->

    <!-- TABLE PRODUCTS-->
    <br>
    <div class=" bg-primary bg-opacity-10">
        <hr>
        <h2 class="text-center">TABLE PETS</h2>
        <hr>
    </div>

    <div class="table1 border-top border-bottom border-5 rounded-top rounded-bottom border-primary">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">ID #</th>
                    <th scope="col" class="pictImg">Picture</th>
                    <th scope="col" class="titleRow">Petname</th>
                    <th scope="col" class="isbn">Age</th>

                    <!-- <th scope="col" class="availa">Available</th> -->
                    <th scope="col" class="usedP">Vaccinated</th>
                    <th scope="col">UserId</th>
                    <th scope="col" class="availa">Available</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?= $layoutProducts; ?>
            </tbody>
        </table>
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