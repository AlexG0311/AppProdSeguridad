<?php
session_start();

// Simulación de datos (puedes reemplazar con base de datos)
$courses = [
    1 => ['nombre' => 'Trabajo en Alturas', 'descripcion' => 'Aprende a trabajar en altura de forma segura.'],
    2 => ['nombre' => 'Primeros Auxilios', 'descripcion' => 'Prepárate para emergencias médicas.'],
    3 => ['nombre' => 'Manejo de Sustancias Peligrosas', 'descripcion' => 'Capacitación en manejo de químicos.'],
    4 => ['nombre' => 'Uso de EPP', 'descripcion' => 'Entrenamiento en equipos de protección personal.'],
];

// Simulación de módulos y lecciones con más información
$modules = [
    1 => [
        [
            'titulo' => 'Módulo 1: Introducción a la Seguridad en Alturas',
            'descripcion' => 'Este módulo cubre los fundamentos básicos de la seguridad al trabajar en alturas, incluyendo regulaciones y equipos esenciales.',
            'imagen' => 'https://via.placeholder.com/300x200?text=Módulo+1',
            'lecciones' => [
                ['titulo' => 'Conceptos Básicos', 'tipo' => 'video', 'contenido' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
                ['titulo' => 'Normas de Seguridad', 'tipo' => 'material', 'contenido' => 'materiales/normas_seguridad.pdf'],
            ],
        ],
        [
            'titulo' => 'Módulo 2: Uso de Equipos',
            'descripcion' => 'Aprende el uso correcto de arneses, cuerdas y otros equipos de protección personal para trabajos en altura.',
            'imagen' => 'https://via.placeholder.com/300x200?text=Módulo+2',
            'lecciones' => [
                ['titulo' => 'Uso de Arnés', 'tipo' => 'video', 'contenido' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
                ['titulo' => 'Manual de Equipos', 'tipo' => 'material', 'contenido' => 'materiales/manual_equipos.pdf'],
            ],
        ],
    ],
    2 => [
        [
            'titulo' => 'Módulo 1: Fundamentos de Primeros Auxilios',
            'descripcion' => 'Conoce las técnicas básicas de primeros auxilios para responder a emergencias médicas en el lugar de trabajo.',
            'imagen' => 'https://via.placeholder.com/300x200?text=Módulo+1+Primeros+Auxilios',
            'lecciones' => [
                ['titulo' => 'Introducción a Primeros Auxilios', 'tipo' => 'video', 'contenido' => 'https://www.w3schools.com/html/mov_bbb.mp4'],
                ['titulo' => 'Manual Básico', 'tipo' => 'material', 'contenido' => 'materiales/manual_primeros_auxilios.pdf'],
            ],
        ],
        [
            'titulo' => 'Módulo 2: Técnicas de RCP',
            'descripcion' => 'Domina las técnicas de reanimación cardiopulmonar (RCP) para salvar vidas en situaciones críticas.',
            'imagen' => 'https://via.placeholder.com/300x200?text=Módulo+2+RCP',
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
    3 => ['user_id' => 2, 'course_id' => 3, 'progreso' => 30],
];

// Simulación de compras
$purchases = [
    1 => ['user_id' => 1, 'course_id' => 1],
    2 => ['user_id' => 1, 'course_id' => 2],
    3 => ['user_id' => 2, 'course_id' => 3],
];

// Obtener el ID del curso
$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
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
                    <a href="#" id="auth-link"></a>
                </div>
            </nav>
        </header>
        <section class="course-detail">
            <div class="section-content">
                <div id="course-content"></div>
            </div>
        </section>
        <footer>
            <div class="footer-content">
                <h3>Productos de Seguridad</h3>
                <p>© 2025 Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>

    <script>
        // Verificar autenticación
        const isAuthenticated = localStorage.getItem('isAuthenticated') === 'true';
        const userId = localStorage.getItem('user_id');
        const authLink = document.getElementById('auth-link');

        if (!isAuthenticated) {
            window.location.href = 'login.php';
        } else {
            authLink.textContent = 'Cerrar Sesión';
            authLink.addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.removeItem('isAuthenticated');
                localStorage.removeItem('user_id');
                window.location.href = 'login.php';
            });

            // Obtener datos del curso
            const courseId = <?php echo $course_id; ?>;
            const courses = <?php echo json_encode($courses); ?>;
            const modules = <?php echo json_encode($modules); ?>;
            const progress = <?php echo json_encode($progress); ?>;
            const purchases = <?php echo json_encode($purchases); ?>;

            // Verificar si el curso existe
            if (!courses[courseId]) {
                document.getElementById('course-content').innerHTML = '<h1>Curso no encontrado</h1>';
            } else if (!purchases.some(p => p.user_id == userId && p.course_id == courseId)) {
                document.getElementById('course-content').innerHTML = '<h1>No tienes acceso a este curso</h1>';
            } else {
                // Obtener progreso
                let progreso = 0;
                progress.forEach(prog => {
                    if (prog.user_id == userId && prog.course_id == courseId) {
                        progreso = prog.progreso;
                    }
                });

                // Generar contenido del curso
                let html = `
                    <h1>${courses[courseId].nombre}</h1>
                    <p>${courses[courseId].descripcion}</p>
                    <div class="progress-bar">
                        <div class="progress" style="width: ${progreso}%;"></div>
                    </div>
                    <p>Progreso: ${progreso}%</p>
                    ${progreso == 100 ? `<a href="download.php?type=certificate&course_id=${courseId}" class="btn-info">Descargar Certificado</a>` : ''}
                    <div class="course-layout">
                        <aside class="modules-sidebar">
                `;

                if (modules[courseId]) {
                    modules[courseId].forEach((module, index) => {
                        html += `
                            <details class="module-accordion" ${index === 0 ? 'open' : ''}>
                                <summary>${module.titulo}</summary>
                                <div class="module-info">
                                    <img src="${module.imagen}" alt="${module.titulo}" class="module-image">
                                    <p>${module.descripcion}</p>
                                </div>
                                <ul class="lessons-list">
                        `;
                        module.lecciones.forEach((lesson, lessonIndex) => {
                            html += `
                                <li class="lesson-item" data-lesson-id="${index}-${lessonIndex}">
                                    <a href="#" class="lesson-link" 
                                       data-title="${lesson.titulo}"
                                       data-type="${lesson.tipo}"
                                       data-content="${lesson.contenido}">
                                        ${lesson.titulo}
                                    </a>
                                </li>
                            `;
                        });
                        html += `
                                </ul>
                            </details>
                        `;
                    });
                } else {
                    html += '<p>No hay módulos disponibles para este curso.</p>';
                }

                html += `
                        </aside>
                        <div class="lesson-content">
                            <h2 id="lesson-title">${modules[courseId][0].lecciones[0].titulo}</h2>
                            <div id="lesson-content-inner">
                                ${modules[courseId][0].lecciones[0].tipo === 'video' ? `
                                    <video controls class="lesson-video">
                                        <source src="${modules[courseId][0].lecciones[0].contenido}" type="video/mp4">
                                        Tu navegador no soporta el elemento de video.
                                    </video>
                                ` : `
                                    <p>Material descargable:</p>
                                    <a href="download.php?type=material&file=${encodeURIComponent(modules[courseId][0].lecciones[0].contenido)}" class="btn-info">Descargar</a>
                                `}
                            </div>
                        </div>
                    </div>
                `;

                document.getElementById('course-content').innerHTML = html;

                // Manejar cambio dinámico de contenido
                const lessonLinks = document.querySelectorAll('.lesson-link');
                const lessonTitle = document.getElementById('lesson-title');
                const lessonContentInner = document.getElementById('lesson-content-inner');

                lessonLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const title = link.getAttribute('data-title');
                        const type = link.getAttribute('data-type');
                        const content = link.getAttribute('data-content');

                        lessonTitle.textContent = title;
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
            }
        }
    </script>
</body>
</html>