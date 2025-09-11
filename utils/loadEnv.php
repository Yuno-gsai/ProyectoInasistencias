<?php
function loadEnv(string $path)
{
    if (!file_exists($path)) {
        throw new Exception(".env file not found at $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorar comentarios
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        // Separar clave y valor
        list($name, $value) = array_map('trim', explode('=', $line, 2));

        // Quitar comillas si existen
        $value = trim($value, "\"'");

        // Guardar en $_ENV y $_SERVER
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
        putenv("$name=$value"); // opcional
    }
}
