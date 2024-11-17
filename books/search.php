<?php
include('DbConnect.php');
require_once('Books.php');

$conn = new DbConnect();
$dbConnection = $conn->connect();

$instanceBooks = new Books($dbConnection);
$books = $instanceBooks->getBooks();

if (isset($_GET['ISBN']) || isset($_GET['firstName']) || isset($_GET['lastName']) || isset($_GET['title']) || isset($_GET['description']))
{
    $selISBN = $_GET['ISBN'];
    $selFirstName = $_GET['firstName'];
    $selLastName = $_GET['lastName'];
    $selTitle = $_GET['title'];
    $selDescription = $_GET['description'];
    $selBooks = $instanceBooks->filterBooks($selISBN, $selFirstName, $selLastName, $selTitle,$selDescription);  
}
else 
{
    $selBooks = $books;  
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
        <h2 class="h2">Search book</h2>
        <form action="search.php" method="get">
            <input type="text" name="ISBN" class="form-control my-2" placeholder="ISBN">
            <input type="text" name="firstName" class="form-control my-2" placeholder="author's first name">
            <input type="text" name="lastName" class="form-control my-2" placeholder="author's last name">
            <input type="text" name="title" class="form-control my-2" placeholder="title of the book">
            <textarea name="description" rows="4" cols="50" class="form-control my-2" placeholder="description of the book" required></textarea>
            <input class="btn btn-primary my-2" type="submit" value="Search">
        </form>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>ISBN</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Title</th>
            <th>Description</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php
            foreach($selBooks as $book):
        ?>
            <tr>
                <td><?php echo $book['id']?></td>
                <td><?php echo $book['ISBN']?></td>
                <td><?php echo $book['firstName']?></td>
                <td><?php echo $book['lastName']?></td>
                <td><?php echo $book['title']?></td>
                <td><?php echo $book['description']?></td>
                <td>
                    <a class="btn btn-warning" href="edit.php?id=<?php echo $book['id'] ?>">Edit</a>
                </td>
                <td>
                    <a class="btn btn-warning" href="index.php?delete=<?php echo $book['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php
            endforeach;
        ?>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>  
</body>
</html>