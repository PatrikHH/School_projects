<?php
include('DbConnect.php');
require_once('Books.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();

$instanceBooks = new Books($dbConnection);
if(isset($_POST['add']))
{
    $ISBN = $_POST['ISBN'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $instanceBooks->addBook($ISBN, $firstName, $lastName, $title, $description);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Books</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Books</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="search.php">Search book</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="add.php">Add book</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="edit.php">Edit book</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
        <h2 class="h2">Adding book</h2>
        <form action="add.php" method="post">
            <input type="text" name="ISBN" class="form-control my-2" placeholder="ISBN" required>
            <input type="text" name="firstName" class="form-control my-2" placeholder="author's first name" required>
            <input type="text" name="lastName" class="form-control my-2" placeholder="author's last name" required>
            <input type="text" name="title" class="form-control my-2" placeholder="title of the book" required>
            <textarea name="description" rows="4" cols="50" class="form-control my-2" placeholder="description of the book" required></textarea>
            <input type="submit" name="add" value="Add book" class="btn btn-primary my-2">
        </form>     
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>  
</body>
</html>