<?php
session_start();
if(!isset($_SESSION['administrador'])){
    header("Location: /ProyectoInasistenciasItca/index.php");
}
$dataAdmin=$_SESSION['administrador'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITCA FEPADE - Sistema Educativo</title>
    <link rel="icon" type="image/png" href="/LogoITCA_2024_FC_Moodle.png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-gold': '#D4A147',
                        'primary-red': '#B85450',
                        'secondary-gold': '#E6B85C',
                        'light-gray': '#F5F5F5',
                        'medium-gray': '#E0E0E0',
                        'dark-gray': '#666666',
                        'text-primary': '#2C3E50',
                        'text-secondary': '#5A6C7D',
                    },
                    fontFamily: {
                        'inter': ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Oxygen', 'sans-serif'],
                    },
                    boxShadow: {
                        'light': '0 2px 8px rgba(0, 0, 0, 0.08)',
                        'medium': '0 4px 16px rgba(0, 0, 0, 0.12)',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-inter bg-light-gray text-text-primary min-h-screen">
    <!-- Header -->
    <?php include 'menu.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 py-10 px-6">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-4xl font-bold text-text-primary mb-12 text-center">Panel de Control</h1>
            
            <!-- Dashboard Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
               <!-- Listado de alumnos -->
                <a href="listado_alumnos.php">
                <div class="dashboard-card bg-white rounded-xl p-12 text-center shadow-light cursor-pointer transition-all duration-300 border border-transparent hover:shadow-medium hover:-translate-y-1 hover:border-medium-gray group relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-gold to-primary-red opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center bg-light-gray rounded-2xl text-primary-red transition-all duration-300 group-hover:bg-primary-gold group-hover:text-white group-hover:scale-110">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none">
                            <path d="M12 3L1 9L12 15L21 9V16H23V9L12 3Z" stroke="currentColor" stroke-width="1.5" fill="currentColor"/>
                            <path d="M5 13.18V17.18C5 19.39 8.13 21 12 21S19 19.39 19 17.18V13.18L12 16L5 13.18Z" stroke="currentColor" stroke-width="1.5" fill="currentColor"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-text-primary mb-3 leading-tight">Listado de alumnos</h3>
                    <p class="text-text-secondary text-sm leading-relaxed max-w-xs mx-auto">Gestionar información de estudiantes</p>
                </div>
                </a>
                <!-- Listado de seguimiento -->
                 <a href="listado_segimiento.php">
                <div class="dashboard-card bg-white rounded-xl p-12 text-center shadow-light cursor-pointer transition-all duration-300 border border-transparent hover:shadow-medium hover:-translate-y-1 hover:border-medium-gray group relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-gold to-primary-red opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center bg-light-gray rounded-2xl text-primary-red transition-all duration-300 group-hover:bg-primary-gold group-hover:text-white group-hover:scale-110">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5" fill="currentColor" fill-opacity="0.1"/>
                            <path d="M9 11L12 14L22 4" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <path d="M7 13L9 15" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            <path d="M7 17L9 19" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-text-primary mb-3 leading-tight">Listado de seguimiento</h3>
                    <p class="text-text-secondary text-sm leading-relaxed max-w-xs mx-auto">Monitorear progreso académico</p>
                </div>
                </a>
                <!-- Listado seguimiento cancelado -->
                <a href="listado_finalizado.php">
                <div class="dashboard-card bg-white rounded-xl p-12 text-center shadow-light cursor-pointer transition-all duration-300 border border-transparent hover:shadow-medium hover:-translate-y-1 hover:border-medium-gray group relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-gold to-primary-red opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center bg-light-gray rounded-2xl text-primary-red transition-all duration-300 group-hover:bg-primary-gold group-hover:text-white group-hover:scale-110">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5" fill="currentColor" fill-opacity="0.1"/>
                            <path d="M8 8L16 16M16 8L8 16" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M3 8H21" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-text-primary mb-3 leading-tight">Listado seguimiento finalizado</h3>
                    <p class="text-text-secondary text-sm leading-relaxed max-w-xs mx-auto">Revisar seguimientos finalizados</p>
                </div>
                </a>
            </div>
        </div>
    </main>

    <script>
        // Add click handlers for dashboard cards
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.dashboard-card');
            
            cards.forEach(card => {
                card.addEventListener('click', (e) => {
                    const title = card.querySelector('h3').textContent;
                    console.log(`Navegando a: ${title}`);
                    
                    // Add visual feedback
                    card.style.transform = 'scale(0.98) translateY(-2px)';
                    setTimeout(() => {
                        card.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
</body>
</html>