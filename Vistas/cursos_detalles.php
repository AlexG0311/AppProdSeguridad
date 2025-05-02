<?php
session_start();

// Simular que el usuario siempre está logueado (para pruebas)
$_SESSION['user_id'] = 1; // Asignamos un ID de usuario fijo para simulación

// Obtener el ID del curso
$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;

// Simulación de datos (puedes reemplazar con base de datos)
$courses = [
    1 => ['nombre' => 'Trabajo en Alturas', 'descripcion' => 'Aprende a trabajar en altura de forma segura.'],
    2 => ['nombre' => 'Primeros Auxilios', 'descripcion' => 'Prepárate para emergencias médicas.'],
    3 => ['nombre' => 'Manejo de Sustancias Peligrosas', 'descripcion' => 'Capacitación en manejo de químicos.'],
    4 => ['nombre' => 'Uso de EPP', 'descripcion' => 'Entrenamiento en equipos de protección personal.'],
];

// Simulación de módulos y lecciones (puedes reemplazar con base de datos)
$modules = [
    1 => [
        [
            'nombre' => 'Módulo 1: Introducción a la Seguridad en Alturas',
            'lecciones' => [
                ['titulo' => 'Conceptos Básicos', 'tipo' => 'video', 'contenido' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
                ['titulo' => 'Normas de Seguridad', 'tipo' => 'material', 'contenido' => 'materiales/normas_seguridad.pdf'],
            ],
        ],
        [
            'nombre' => 'Módulo 2: Uso de Equipos',
            'lecciones' => [
                ['titulo' => 'Uso de Arnés', 'tipo' => 'video', 'contenido' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
                ['titulo' => 'Manual de Equipos', 'tipo' => 'material', 'contenido' => 'materiales/manual_equipos.pdf'],
            ],
        ],
    ],
    2 => [
        [
            'nombre' => 'Módulo 1: Fundamentos de Primeros Auxilios',
            'lecciones' => [
                ['titulo' => 'Introducción a Primeros Auxilios', 'tipo' => 'video', 'contenido' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
                ['titulo' => 'Manual Básico', 'tipo' => 'material', 'contenido' => 'materiales/manual_primeros_auxilios.pdf'],
            ],
        ],
        [
            'nombre' => 'Módulo 2: Técnicas de RCP',
            'lecciones' => [
                ['titulo' => 'Cómo Realizar RCP', 'tipo' => 'video', 'contenido' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
            ],
        ],
    ],
];

// Simulación de progreso (puedes reemplazar con base de datos)
$progress = [
    1 => ['user_id' => 1, 'course_id' => 1, 'progreso' => 50],
    2 => ['user_id' => 1, 'course_id' => 2, 'progreso' => 100],
];

// Verificar si el curso existe
if (!isset($courses[$course_id])) {
    echo "<h1>Curso no encontrado</h1>";
    exit;
}

// Verificar si el usuario ha comprado el curso (simulado)
$purchases = [1, 2]; // Cursos comprados por el usuario (simulado)
if (!in_array($course_id, $purchases)) {
    echo "<h1>No tienes acceso a este curso</h1>";
    exit;
}

// Obtener progreso
$progreso = 0;
foreach ($progress as $prog) {
    if ($prog['user_id'] == $_SESSION['user_id'] && $prog['course_id'] == $course_id) {
        $progreso = $prog['progreso'];
        break;
    }
}

// Seleccionar el contenido inicial (primera lección del primer módulo)
$contenido_inicial = null;
if (isset($modules[$course_id][0]['lecciones'][0])) {
    $contenido_inicial = $modules[$course_id][0]['lecciones'][0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/cursos_detalles.css">
    <title><?php echo htmlspecialchars($courses[$course_id]['nombre']); ?> - Productos de Seguridad</title>
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
        <section class="course-detail">
            <div class="section-content">
                <h1><?php echo htmlspecialchars($courses[$course_id]['nombre']); ?></h1>
                <p><?php echo htmlspecialchars($courses[$course_id]['descripcion']); ?></p>
                <div class="progress-bar">
                    <div class="progress" style="width: <?php echo $progreso; ?>%;"></div>
                </div>
                <p>Progreso: <?php echo $progreso; ?>%</p>
                <?php if ($progreso == 100): ?>
                    <a href="download.php?type=certificate&course_id=<?php echo $course_id; ?>" class="btn-info">Descargar Certificado</a>
                <?php endif; ?>

                <div class="course-layout">
                    <!-- Acordeones de módulos (izquierda) -->
                    <aside class="modules-sidebar">
                        <?php if (isset($modules[$course_id])): ?>
                            <?php foreach ($modules[$course_id] as $index => $module): ?>
                                <details class="module-accordion" <?php echo $index === 0 ? 'open' : ''; ?>>
                                    <summary><?php echo htmlspecialchars($module['nombre']); ?></summary>
                                    <ul class="lessons-list">
                                        <?php foreach ($module['lecciones'] as $lesson_index => $lesson): ?>
                                            <li class="lesson-item" data-lesson-id="<?php echo $index . '-' . $lesson_index; ?>">
                                                <a href="#" class="lesson-link" 
                                                   data-title="<?php echo htmlspecialchars($lesson['titulo']); ?>"
                                                   data-type="<?php echo htmlspecialchars($lesson['tipo']); ?>"
                                                   data-content="<?php echo htmlspecialchars($lesson['contenido']); ?>">
                                                    <?php echo htmlspecialchars($lesson['titulo']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </details>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay módulos disponibles para este curso.</p>
                        <?php endif; ?>
                    </aside>

                    <!-- Contenido de las lecciones (derecha) -->
                    <div class="lesson-content">
                        <?php if ($contenido_inicial): ?>
                            <h2 id="lesson-title"><?php echo htmlspecialchars($contenido_inicial['titulo']); ?></h2>
                            <div id="lesson-content-inner">
                                <?php if ($contenido_inicial['tipo'] === 'video'): ?>
                                    <video controls class="lesson-video">
                                        <source src="<?php echo htmlspecialchars($contenido_inicial['contenido']); ?>" type="video/mp4">
                                        Tu navegador no soporta el elemento de video.
                                    </video>
                                <?php elseif ($contenido_inicial['tipo'] === 'material'): ?>
                                    <p>Material descargable:</p>
                                    <a href="download.php?type=material&file=<?php echo urlencode($contenido_inicial['contenido']); ?>" class="btn-info">Descargar</a>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p>Selecciona una lección para ver su contenido.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <div class="footer-content">
                <h3>Productos de Seguridad</h3>
                <p>© 2025 Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>

    <!-- JavaScript para manejar el cambio dinámico de contenido -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const lessonLinks = document.querySelectorAll('.lesson-link');
            const lessonTitle = document.getElementById('lesson-title');
            const lessonContentInner = document.getElementById('lesson-content-inner');

            lessonLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();

                    // Obtener datos de la lección desde los atributos data
                    const title = link.getAttribute('data-title');
                    const type = link.getAttribute('data-type');
                    const content = link.getAttribute('data-content');

                    // Actualizar el título
                    lessonTitle.textContent = title;

                    // Actualizar el contenido según el tipo
                    if (type === 'video') {
                        lessonContentInner.innerHTML = `
                            <video controls class="lesson-video">
                                <source src="${content}" type="video/mp4">
                                Tu navegador no soporta el elemento de video.
                            </video>
                        `;
                    } else if (type === 'material') {
                        lessonContentInner.innerHTML = `
                            <p>Material descargable:</p>
                            <a href="download.php?type=material&file=${encodeURIComponent(content)}" class="btn-info">Descargar</a>
                        `;
                    }
                });
            });
        });
    </script>
</body>
</html>