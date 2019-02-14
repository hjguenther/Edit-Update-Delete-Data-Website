<?php
require_once "con_product_ratings.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['name_id']) ) {
    $sql = "DELETE FROM product_ratings WHERE name_id = :name_id_ref";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':name_id_ref' => $_POST['name_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: display_table.php' ) ;
    return;
}

// Guardian: Make sure that name_id is present
if ( ! isset($_GET['name_id']) ) {
  $_SESSION['error'] = "Missing name_id";
  header('Location: display_table.php');
  return;
}

$stmt = $conn->prepare("SELECT name, name_id FROM product_ratings where name_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['name_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for name_id';
    header( 'Location: display_table.php' ) ;
    return;
}

?>
<p>Confirm: Deleting <?= htmlentities($row['name']) ?></p>

<form method="post">
<input type="hidden" name="name_id" value="<?= $row['name_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="display_table.php">Cancel</a>
</form>
