<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Determinar el tipo de descarga
$type = isset($_GET['type']) ? $_GET['type'] : '';
$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
$file = isset($_GET['file']) ? urldecode($_GET['file']) : '';

// Simulación de compras (puedes reemplazar con base de datos)
$purchases = [1, 2]; // Cursos comprados por el usuario

if ($type === 'certificate') {
    // Verificar si el usuario tiene acceso al curso
    if (!in_array($course_id, $purchases)) {
        echo "No tienes acceso a este curso.";
        exit;
    }

    // Simulación de progreso (puedes reemplazar con base de datos)
    $progress = [
        1 => ['user_id' => 1, 'course_id' => 1, 'progreso' => 50],
        2 => ['user_id' => 1, 'course_id' => 2, 'progreso' => 100],
    ];

    $progreso = 0;
    foreach ($progress as $prog) {
        if ($prog['user_id'] == $_SESSION['user_id'] && $prog['course_id'] == $course_id) {
            $progreso = $prog['progreso'];
            break;
        }
    }

    // Verificar si el curso está completado
    if ($progreso < 100) {
        echo "Debes completar el curso para descargar el certificado.";
        exit;
    }

    // Simulación de generación de certificado (en un entorno real, usarías FPDF)
    $certificate_content = "Certificado de Finalización\n\n" .
                          "Se certifica que [Nombre del Usuario] ha completado el curso\n" .
                          "ID: {$course_id}\nFecha: 2025-05-01";

    // Enviar el certificado como PDF simulado
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="certificado_curso_' . $course_id . '.pdf"');
    echo $certificate_content; // En un entorno real, usarías FPDF para generar un PDF real
    exit;

} elseif ($type === 'material') {
    // Verificar si el archivo existe
    if (!file_exists($file)) {
        echo "Archivo no encontrado.";
        exit;
    }

    // Obtener el ID del curso a partir de la ruta del archivo (simulado)
    $course_id_from_file = 1; // Esto debería deducirse de la ruta o una consulta a la base de datos
    if (!in_array($course_id_from_file, $purchases)) {
        echo "No tienes acceso a este material.";
        exit;
    }

    // Descargar el archivo
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
} else {
    echo "Tipo de descarga no válido.";
    exit;
}
?>