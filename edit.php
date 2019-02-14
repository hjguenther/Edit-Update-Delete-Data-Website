<?php
require_once "con_product_ratings.php";
session_start();

if ( isset($_POST['name']) && isset($_POST['brand'])
     && isset($_POST['years_owned']) && isset($_POST['rating'])
     && isset($_POST['name_id']) ) {

    // Data validation
    if ( strlen($_POST['name']) < 1 || strlen($_POST['brand']) < 1
         || strlen($_POST['years_owned']) < 1 || strlen($_POST['rating']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php?name_id=".$_POST['name_id']);
        return;
    }

    if ( $_POST['rating'] > 10 || $_POST['rating'] <= 0 ) {
        $_SESSION['error'] = 'rating needs to be between 1-10';
        header("Location: insert.php");
        return;
    }

    $sql = "UPDATE product_ratings SET name = :name,
            brand = :brand, years_owned = :years_owned, rating = :rating
            WHERE name_id = :name_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['name'],
        ':brand' => $_POST['brand'],
        ':years_owned' => $_POST['years_owned'],
        ':rating' => $_POST['rating'],
        ':name_id' => $_POST['name_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: display_table.php' ) ;
    return;
}

// Guardian: Make sure that name_id is present
if ( ! isset($_GET['name_id']) ) {
  $_SESSION['error'] = "Missing name_id";
  header('Location: display_table.php');
  return;
}

$stmt = $conn->prepare("SELECT * FROM product_ratings where name_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['name_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for name_id';
    header( 'Location: display_table.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$n = htmlentities($row['name']);
$b = htmlentities($row['brand']);
$y = htmlentities($row['years_owned']);
$r = htmlentities($row['rating']);
$name_id = $row['name_id'];
?>
<p>Edit User</p>
<form method="post">
<p>Name:
<input type="text" name="name" value="<?= $n ?>"></p>
<p>Brand:
<input type="text" name="brand" value="<?= $b ?>"></p>
<p>Years Owned:
<input type="text" name="years_owned" value="<?= $y ?>"></p>
<p>Rating:
<input type="text" name="rating" value="<?= $r ?>"></p>
<input type="hidden" name="name_id" value="<?= $name_id ?>">
<p><input type="submit" value="Update"/>
<a href="display_table.php">Cancel</a></p>
</form>
