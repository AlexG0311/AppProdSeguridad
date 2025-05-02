<?php
session_start();

// Simular que el usuario siempre está logueado (para pruebas)
$_SESSION['user_id'] = 1; // Asignamos un ID de usuario fijo para simulación

// Simulación de datos (puedes reemplazar con base de datos)
$user_id = $_SESSION['user_id'];
$courses = [
    1 => ['nombre' => 'Trabajo en Alturas', 'descripcion' => 'Aprende a trabajar en altura de forma segura.'],
    2 => ['nombre' => 'Primeros Auxilios', 'descripcion' => 'Prepárate para emergencias médicas.'],
    3 => ['nombre' => 'Manejo de Sustancias Peligrosas', 'descripcion' => 'Capacitación en manejo de químicos.'],
    4 => ['nombre' => 'Uso de EPP', 'descripcion' => 'Entrenamiento en equipos de protección personal.'],
];

// Simulación de compras y progreso (puedes reemplazar con base de datos)
$purchases = [
    1 => ['user_id' => 1, 'course_id' => 1, 'fecha' => '2025-04-01'], // Curso 1 comprado
    2 => ['user_id' => 1, 'course_id' => 2, 'fecha' => '2025-04-02'], // Curso 2 comprado
];

// Simulación de progreso (puedes reemplazar con base de datos)
$progress = [
    1 => ['user_id' => 1, 'course_id' => 1, 'progreso' => 50], // Curso 1 al 50%
    2 => ['user_id' => 1, 'course_id' => 2, 'progreso' => 100], // Curso 2 completado
];

// Filtrar cursos comprados por el usuario
$user_courses = [];
foreach ($purchases as $purchase) {
    if ($purchase['user_id'] == $user_id) {
        $course_id = $purchase['course_id'];
        $progreso = 0;
        foreach ($progress as $prog) {
            if ($prog['user_id'] == $user_id && $prog['course_id'] == $course_id) {
                $progreso = $prog['progreso'];
                break;
            }
        }
        $user_courses[] = [
            'id' => $course_id,
            'nombre' => $courses[$course_id]['nombre'],
            'descripcion' => $courses[$course_id]['descripcion'],
            'progreso' => $progreso,
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/App.css">
    <title>Mis Cursos - Productos de Seguridad</title>
</head>
<body>
    <div id="contenedor">
        <header>
            <div class="logo">Productos de Seguridad</div>
            <nav>
                <div class="nav-01">
                    <a href="index.php">Inicio</a>
                    <a href="catalog.php">Productos</a>
                    <a href="cursos.php">Cursos</a>
                    <a href="carrito.php">Carrito</a>
                    <a href="mis_cursos.php">Mis Cursos</a>
                    <a href="logout.php">Cerrar Sesión</a>
                </div>
            </nav>
        </header>
        <section class="my-courses">
            <div class="section-content">
                <h1>Mis Cursos</h1>
                <p>Aquí puedes ver los cursos que has comprado, tu progreso y descargar certificados.</p>
                <?php if (empty($user_courses)): ?>
                    <p>No has comprado ningún curso aún. <a href="cursos.php" class="btn-secondary">Explora nuestros cursos</a></p>
                <?php else: ?>
                    <div class="courses-grid">
                        <?php foreach ($user_courses as $course): ?>
                            <div class="course-item">
                                <h3><?php echo htmlspecialchars($course['nombre']); ?></h3>
                                <p><?php echo htmlspecialchars($course['descripcion']); ?></p>
                                <div class="progress-bar">
                                    <div class="progress" style="width: <?php echo $course['progreso']; ?>%;"></div>
                                </div>
                                <p>Progreso: <?php echo $course['progreso']; ?>%</p>
                                <div class="course-actions">
                                    <a href="cursos_detalles.php?course_id=<?php echo $course['id']; ?>" class="btn-secondary">Continuar</a>
                                    <?php if ($course['progreso'] == 100): ?>
                                        <a href="download.php?type=certificate&course_id=<?php echo $course['id']; ?>" class="btn-info">Descargar Certificado</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <footer>
            <div class="footer-content">
                <h3>Productos de Seguridad</h3>
                <p>© 2025 Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>