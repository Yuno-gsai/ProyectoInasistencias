<header class="bg-gray-300 shadow-sm">
    <div class="flex items-center justify-between px-6 py-3">
        <!-- Logo ITCA -->
        <div class="flex items-center space-x-4">
            <!-- Logo ITCA FEPADE -->
           <a href="dashboard.php"> <img src="../Publico/imagenes/itcaLogo.png" alt="ITCA FEPADE" class="h-12 w-auto"></a>
            
            <a href="dashboard.php">
                <button class="bg-gray-500 text-white px-6 py-2 text-sm font-medium rounded hover:bg-gray-600 transition duration-200">
                    Inicio
                </button>
            </a>
        </div>
        
        <!-- User Section with Dropdown -->
        <div class="relative flex items-center space-x-3">
            <div class="flex items-center space-x-3 cursor-pointer" id="user-menu-button">
                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center border-2 border-gray-400">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="text-gray-700 font-medium">German</span>
                <!-- Dropdown arrow -->
                <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" id="dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            
            <!-- Dropdown Menu -->
            <div class="absolute right-0 top-12 hidden bg-white rounded-md shadow-lg py-1 w-48 border border-gray-200 z-50" id="user-dropdown">
                <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                    <p class="font-medium">German</p>
                    <p class="text-gray-500 text-xs">Usuario</p>
                </div>
                <a href="perfil.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150">
                    👤 Mi Perfil
                </a>
                <a href="../Login/Logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-150">
                    🚪 Cerrar Sesión
                </a>
            </div>
        </div>
    </div>
</header>

<script>
    // JavaScript para controlar el dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuButton = document.getElementById('user-menu-button');
        const dropdownMenu = document.getElementById('user-dropdown');
        const dropdownArrow = document.getElementById('dropdown-arrow');

        // Alternar el menú al hacer clic
        userMenuButton.addEventListener('click', function() {
            const isHidden = dropdownMenu.classList.contains('hidden');
            
            if (isHidden) {
                dropdownMenu.classList.remove('hidden');
                dropdownArrow.classList.add('rotate-180');
            } else {
                dropdownMenu.classList.add('hidden');
                dropdownArrow.classList.remove('rotate-180');
            }
        });

        // Cerrar el menú al hacer clic fuera de él
        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
                dropdownArrow.classList.remove('rotate-180');
            }
        });
    });
</script>