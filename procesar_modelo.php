<?php
// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "";
$base_de_datos = "mi_base_de_datos"; // CAMBIA esto por el nombre real de tu base de datos

$conexion = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si los datos vienen por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_modelo = $_POST['id_modelo'];
    $nombre = $_POST['nombre'];

    // Preparar y ejecutar consulta segura
    $sql = "INSERT INTO modelo (id_modelo, nombre) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $id_modelo, $nombre);
        if ($stmt->execute()) {
            header("Location: modelo.html?msg=guardado");
            exit();
        } else {
            echo "Error al guardar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación: " . $conexion->error;
    }
} else {
    // Si no vino por POST
    http_response_code(405);
    echo "Método no permitido.";
}

$conexion->close();
?>
