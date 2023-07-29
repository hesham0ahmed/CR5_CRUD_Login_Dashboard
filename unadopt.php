<?php
session_start();
require_once 'db_connect.php';

if (isset($_POST['pet_id']) && isset($_POST['user_id'])) {
  $petId = $_POST['pet_id'];
  $userId = $_POST['user_id'];

  // Check if the pet with the given ID is adopted by the specified user
  $sqlCheckAdoption = "SELECT * FROM pet_adopt WHERE fk_animalID = $petId AND fk_userID = $userId";
  $resultCheckAdoption = mysqli_query($connect, $sqlCheckAdoption);

  if (mysqli_num_rows($resultCheckAdoption) > 0) {
    // The pet is adopted by the specified user, so remove the adoption record
    $sqlRemoveAdoption = "DELETE FROM pet_adopt WHERE fk_animalID = $petId AND fk_userID = $userId";
    $resultRemoveAdoption = mysqli_query($connect, $sqlRemoveAdoption);

    if ($resultRemoveAdoption) {
      // Unadopted successfully
      // Now update the status of the pet to Not Adopted (0)
      $sqlUpdateStatus = "UPDATE animal SET status = 0 WHERE id = $petId";
      $resultUpdateStatus = mysqli_query($connect, $sqlUpdateStatus);

      if ($resultUpdateStatus) {
        header("Location: dashboard.php");
      } else {
        echo "Error updating pet status: " . mysqli_error($connect);
      }
    } else {
      // Error occurred while unadopting
      echo "Error: " . mysqli_error($connect);
    }
  } else {
    // The pet is not adopted by the specified user
    echo "The pet is not adopted by the specified user.";
  }
} else {
  // The form was not submitted properly
  echo "Invalid request.";
}

mysqli_close($connect);
