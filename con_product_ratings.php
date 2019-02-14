<?php
$conn = new PDO('mysql:host=localhost;port=3306;dbname=snowfinder',
   'root', '');
// See the "errors" folder for details...
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
