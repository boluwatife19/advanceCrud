<?php

// Include the SignupConfig class (assuming it's in "./signup.config.php").
require_once('./signup.config.php');

// Create a new instance of the SignupConfig class
$data = new SignupConfig();

// Retrieve all records and pagination information
$allp = $data->page();
$all = $data->fetchAll();

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
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">ADVANCE CRUD</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./index.php">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./signup.php">ADD</a>
          </li>
        </ul>
        <form class="d-flex" role="search" method="post" action="index.php">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" required name="key">
          <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <?php

  // Check if the search form was submitted
  if (isset($_POST['submit'])) {
    $key = $_POST['key'];
    $searchResults = $data->search($key);

    // Handle the results
    $results = $searchResults['results'];
    $rows = $searchResults['rows'];

    if ($rows != 0) {
      // Loop through the results and display them
      foreach ($results as $result) {
        // Display the user information here
  ?>
        <table class="table m-5 bg-black">
          <tbody class="bg-black">
            <tr class="bg-black">
              <th><?= $result['firstname'] ?></th>
              <td><?= $result['lastname'] ?></td>
              <td><?= $result['address'] ?></td>
              <td><a href="./index.php" class="btn btn-danger">CLEAR</a></td>
            </tr>
          </tbody>
        </table>
  <?php
      }
    } else {
      echo "No users found for the provided keyword.";
    }
  }
  ?>

  <!-- List of all Records -->
  <h2>List of all Records</h2>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Firstname</th>
        <th scope="col">Lastname</th>
        <th scope="col">Address</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($all as $key => $value) {
      ?>
        <tr>
          <th><?= $value['firstname'] ?></th>
          <td><?= $value['lastname'] ?></td>
          <td><?= $value['address'] ?></td>
          <td>
            <a href="./delete.php?id=<?= $value['id'] ?>&req=delete" class="btn btn-danger">DELETE</a>
            <a href="./edit.php?id=<?= $value['id'] ?>&req=edit" class="btn btn-warning">UPDATE</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <!-- Pagination -->
  <nav aria-label="Page navigation example">
    <h2><?php

    // Handle the results
    $results = $allp['results'];
    $rows = $allp['pages'];
    echo 'Total Pages: '.$rows;

?></h2>
    <ul class="pagination">
      <li class="page-item"><a class="page-link" href="?page-nr=1">FIRST</a></li>
      <?php
      for ($counter = 1; $counter <= $rows; $counter++) {
      ?>
        <li class="page-item"><a class="page-link" href="?page-nr=<?php echo $counter ?>"><?php echo $counter ?></a></li>
      <?php } ?>
      <li class="page-item"><a class="page-link" href="?page-nr=<?php echo $rows ?>">LAST</a></li>
    </ul>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>
