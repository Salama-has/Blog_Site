<!--Fichero para crear la connexion a la base de datos-->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webblog";

// Create connection
$conexion = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
// Close connection
//$conexion->close();
?>
