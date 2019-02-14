<?php
//refference to connection file via PDO
require_once "con_product_ratings.php";
//initiate session cookies
session_start();
//make sure to name varaible below the PDO connection variable from required php connection above
$stmt = $conn->query("SELECT name, brand, years_owned, rating, name_id FROM product_ratings");
?>

<!DOCTYPE html>

<html lang="en">

<head>

<title>Snowboards</title>
<!--refference to css styling sheet-->
 <link rel="stylesheet" href="sno_style.css">

</head>

<body>

<h4>Snowfinder Ratings</h4>
<?php
// Flash pattern when insert data success
//check why not working
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
//display rating table
echo '<table border = 1>'."\n";
 echo "<tr><th>";
 echo "Name";
 echo "</th><th>";
 echo "Brand";
 echo"</th><th>";
 echo "Years Owned";
 echo"</th><th>";
 echo "Rating 1-10";
 echo"</th><th>";
 echo "Edit";
 echo"</th>";
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  echo"<tr><td>";
  echo(htmlentities($row['name']));
  echo("</td><td>");
  echo(htmlentities($row['brand']));
  echo("</td><td>");
  echo(htmlentities($row['years_owned']));
  echo("</td><td>");
  echo(htmlentities($row['rating']));
  echo("</td><td>");
  echo('<a href="edit.php?name_id='.$row['name_id'].'">Edit</a> / ');
  echo('<a href="delete.php?name_id='.$row['name_id'].'">Delete</a>');
  echo("</td></tr>\n");
}
echo "</table>\n";
?>
<p>
<a href="insert.php">Add Your Rating</a>
</p>
</body>

</html>
