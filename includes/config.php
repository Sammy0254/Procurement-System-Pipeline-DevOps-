<?php
/*
|--------------------------------------------------------------------------
| OWSA-INV V2
|--------------------------------------------------------------------------
| Author: Siamon Hasan
| Project Name: OSWA-INV
| Version: v2
| Offcial page: http://oswapp.com/
| facebook Page: https://www.facebook.com/oswapp
|
|
|
*/
  define( 'DB_HOST', 'localhost' );          // Set database host
  define( 'DB_USER', 'root' );             // Set database user
  define( 'DB_PASS', '' );             // Set database password
  define( 'DB_NAME', 'inventory_system' );        // Set database name

  // Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
