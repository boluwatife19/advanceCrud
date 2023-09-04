<?php

// Include the SignupConfig class (assuming it's in "signup.config.php").
require_once('./signup.config.php');

// Create a new instance of the SignupConfig class
$record = new SignupConfig();

// Check if 'id' and 'req' parameters are set in the URL
if(isset($_GET['id']) && ($_GET['req'])){
    // Check if the 'req' parameter is 'delete'
    if($_GET['req'] == 'delete'){
        // Set the 'id' property of the $record object
        $record->setId($_GET['id']);
        
        // Call the 'delete' method to delete a record
        $record->delete();
        
        // Display a success message and redirect to 'index.php'
        echo "<script>
        alert('Data successfully Deleted'); document.location='index.php'
        </script>";
    }
}

?>
