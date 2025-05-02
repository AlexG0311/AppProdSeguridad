<?php
$host = 'b6crm08367uc9krcpzqz-mysql.services.clever-cloud.com';
$dbname = 'b6crm08367uc9krcpzqz';
$username = 'uwjchdo4sengxjgy';
$password = 'TXVQHjr5cxe8Zgvcuhzw';
$port = 3306; // Puerto predeterminado de MySQL, ajusta si es necesario

// Intentar la conexión
$conexion = mysqli_connect($host, $username, $password, $dbname, $port);

if ($conexion) {
    echo "Conexión Exitosa :) ";
} else {
    // Mostrar el error específico
    die("Error de conexión: " . mysqli_connect_error());
}
?>