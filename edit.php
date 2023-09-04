<?php

// Include the SignupConfig class (assuming it's in "../acrud/signup.config.php").
include '../acrud/signup.config.php';

// Create a new instance of the SignupConfig class
$data = new SignupConfig();

// Get the 'id' parameter from the URL
$id = $_GET['id'];

// Set the 'id' property of the $data object
$data->setId($id);

// Check if the 'edit' form was submitted
if(isset($_POST['edit'])){
    // Set the 'firstname', 'lastname', and 'address' properties of the $data object
    $data->setFirstname($_POST['firstname']);
    $data->setLastname($_POST['lastname']);
    $data->setAddress($_POST['address']);

    // Call the 'update' method to update the record
    echo $data->update();

    // Display a success message and redirect to 'index.php'
    echo "<script>
    alert('Data successfully Edited'); document.location='index.php'
    </script>";
}

// Fetch the record with the specified 'id'
$record = $data->fetchOne();

// Get the first record from the result (assuming there's only one record)
$value = $record[0];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  </head>
  <body>
    <form action="" method="post">
        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" required name="firstname" value="<?= $value['firstname']?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" required name="lastname" value="<?= $value['lastname']?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" class="form-control" required name="address" value="<?= $value['address']?>">
        </div>
        <button type="submit" class="btn btn-primary" name='edit'>UPDATE</button>
      </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  </body>
</html>
