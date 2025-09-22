<?php
require_once "../../models/FaltasModel.php";
$id_alumno = 1;
$alumno = (new Faltas())->getFaltasByAlumno($id_alumno);
$datosAlumno = $alumno[0];
$faltas = !empty($datosAlumno['faltas']) ? json_decode($datosAlumno['faltas'], true) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Perfil de Estudiante</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen">
    <!-- Header -->
    <header class="bg-gray-400 px-6 py-3">
        <div class="flex items-center justify-between">
            <!-- Logo y navegación izquierda -->
            <div class="flex items-center space-x-4">
                <!-- Logo ITCA -->
                <div class="flex items-center">
                    <img src="LogoITCA_2024_FC_Moodle.png" alt="ITCA FEPADE" class="h-10 w-auto">
                </div>
                
                <!-- Botón Inicio -->
                <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 text-sm font-medium transition-colors">
                    Inicio
                </button>
            </div>
            
            <!-- Usuario derecha -->
            <div class="flex items-center space-x-3">
                <!-- Avatar -->
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <!-- Nombre usuario -->
                <span class="text-gray-800 text-sm font-medium">German</span>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container mx-auto px-6 py-8">
        <div class="flex gap-8">
            <!-- Panel izquierdo - Foto y datos básicos -->
            <div class="flex-shrink-0">
                <!-- Foto del estudiante -->
                <div class="bg-white border-4 border-black p-2 mb-4 w-80 h-96">
                    <img src="../../assets/img/usuarios/<?php echo htmlspecialchars($datosAlumno['foto']); ?>" 
                         alt="Foto de <?php echo htmlspecialchars($datosAlumno['nombre']); ?>" 
                         class="w-full h-full object-cover">
                </div>
                
                <!-- Carnet -->
                <div class="text-center mb-4">
                    <h3 class="text-xl font-bold text-black">Carnet</h3>
                    <p class="text-lg text-black"><?php echo htmlspecialchars($datosAlumno['carnet']); ?></p>
                </div>
                
                <!-- Estado -->
                <div class="text-center mb-4">
                    <h3 class="text-xl font-bold text-black">Estado</h3>
                    <span class="px-4 py-1 rounded-full text-sm font-medium <?php echo $datosAlumno['estadoAlumno'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                        <?php echo $datosAlumno['estadoAlumno'] ? 'Activo' : 'Inactivo'; ?>
                    </span>
                </div>
            </div>
            
            <!-- Panel derecho - Datos personales -->
            <div class="flex-1 bg-gray-300 p-8">
                <h2 class="text-2xl font-bold text-black mb-8">DATOS PERSONALES</h2>
                
                <div class="grid grid-cols-2 gap-x-16 gap-y-6">
                    <!-- Fila 1 -->
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Nombre</h3>
                        <p class="text-black"><?php echo htmlspecialchars($datosAlumno['nombre']); ?></p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Apellido</h3>
                        <p class="text-black"><?php echo htmlspecialchars($datosAlumno['apellido']); ?></p>
                    </div>
                    
                    <!-- Fila 2 -->
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Correo electrónico</h3>
                        <p class="text-black"><?php echo htmlspecialchars($datosAlumno['email']); ?></p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Teléfono</h3>
                        <p class="text-black"><?php echo htmlspecialchars($datosAlumno['telefono']); ?></p>
                    </div>
                    
                    <!-- Fila 3 -->
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Fecha de Nacimiento</h3>
                        <p class="text-black"><?php echo date('d/m/Y', strtotime($datosAlumno['fecha_nacimiento'])); ?></p>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-1">Telefono</h3>
                        <p class="text-black"><?php echo htmlspecialchars($datosAlumno['telefono']); ?></p>
                    </div>
                    
                    <!-- Fila 4 -->
                    <?php
                        if($datosAlumno['beca'] == 1){
                            echo '<div>
                                    <h3 class="col-span-2 text-lg font-semibold text-black mb-1">Tipo de beca</h3>
                                    <p class="col-span-2 text-black">'.$datosAlumno['tipobeca'].'</p>
                                </div>';
                        }else{
                            echo '<div>
                                    <h3 class="col-span-2 text-lg font-semibold text-black mb-1">Beca</h3>
                                    <p class="col-span-2 text-black">No</p>
                                </div>';
                        }
                    ?>
                </div>
                
                <!-- Sección de Faltas -->
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-black mb-6">REGISTRO DE FALTAS</h2>
                    <?php if (!empty($faltas)): ?>
                        <div class="space-y-4">
                            <?php foreach ($faltas as $falta): ?>
                                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800">
                                                <?php echo htmlspecialchars($falta['materia']); ?>
                                            </h3>
                                            <p class="text-sm text-gray-600 mt-1">
                                                <span class="font-medium">Grupo:</span> <?php echo htmlspecialchars($falta['grupo']); ?>
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Fecha:</span> 
                                                <?php 
                                                    $fecha = new DateTime($falta['fecha_falta']);
                                                    echo $fecha->format('d/m/Y');
                                                ?>
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Horas:</span> 
                                                <?php 
                                                    echo $falta['cantidadHoras'];
                                                ?>
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            <?php 
                                                $estadoClass = 'bg-gray-100 text-gray-800';
                                                if ($falta['estado'] === 'Justificada') $estadoClass = 'bg-green-100 text-green-800';
                                                elseif ($falta['estado'] === 'Injustificada') $estadoClass = 'bg-red-100 text-red-800';
                                                echo $estadoClass;
                                            ?>">
                                            <?php echo htmlspecialchars($falta['estado']); ?>
                                        </span>
                                    </div>
                                    <?php if (!empty($falta['observacion'])): ?>
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            <p class="text-sm text-gray-700">
                                                <span class="font-medium">Observación:</span> 
                                                <?php echo htmlspecialchars($falta['observacion']); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-white rounded-lg shadow-md p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Sin faltas registradas</h3>
                            <p class="mt-1 text-sm text-gray-500">No se han registrado faltas para este estudiante.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>