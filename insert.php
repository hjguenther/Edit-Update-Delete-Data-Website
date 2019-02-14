<?php
require_once "con_product_ratings.php";
session_start();

if ( isset($_POST['name']) && isset($_POST['brand'])
     && isset($_POST['years_owned']) && isset($_POST['rating'])) {

    // Data validation
    if ( strlen($_POST['name']) < 1 || strlen($_POST['brand']) < 1
         || strlen($_POST['years_owned']) < 1 || strlen($_POST['rating']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: insert.php");
        return;
    }

    if ( $_POST['rating'] > 10 || $_POST['rating'] <= 0 ) {
        $_SESSION['error'] = 'rating needs to be between 1-10';
        header("Location: insert.php");
        return;
    }

    $sql = "INSERT INTO product_ratings (name, brand, years_owned, rating)
              VALUES (:name, :brand, :years_owned, :rating)";
//make sure pdo variable is named appropriatly below from con_product_ratings.php
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ':name' => $_POST['name'],
        ':brand' => $_POST['brand'],
        ':years_owned' => $_POST['years_owned'],
        ':rating' => $_POST['rating']));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: display_table.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<h4>Rate Your Snowboard</h4>
<form method="post">
<p>Name:
<input type="text" name="name"></p>
<p>Brand:
<input type="text" name="brand"></p>
<p>Years you've owned your snowboard:
<input type="number" name="years_owned"></p>
<p>Your rating 1-10:
<input type="number" name="rating"></p>
<p><input type="submit" value="Add New"/>
<a href="display_table.php">Back</a></p>
</form>
