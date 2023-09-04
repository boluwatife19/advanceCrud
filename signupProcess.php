<?php

// Check if the "save" button was clicked in the form
if (isset($_POST['save'])) {
    // Include the SignupConfig class (assuming it's in "./signup.config.php")
    require_once('./signup.config.php');

    // Create an instance of the SignupConfig class
    $sc = new SignupConfig();

    // Set the values from the form to the SignupConfig instance
    $sc->setFirstname($_POST['firstname']);
    $sc->setLastname($_POST['lastname']);
    $sc->setAddress($_POST['address']);

    // Insert the data into the database using the insertData() method
    $sc->insertData();

    // Display a success message and redirect to the index.php page
    echo "<script>
            alert('data successfully inserted'); document.location='./index.php'
        </script>";
}

?>
