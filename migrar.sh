#!/bin/bash
echo "Iniciando migración automática a PSR-4..."

# Reemplazar require antiguos por estatutos 'use' en la carpeta api
if [ -d "api" ]; then
    find api -type f -name "*.php" -exec sed -i "s|require_once.*Controllers/\(.*Controller\)\.php.*;|use App\\\Controllers\\\ \1;|g" {} +
    find api -type f -name "*.php" -exec sed -i "s|require_once.*Helpers/\(.*\)\.php.*;|use App\\\Helpers\\\ \1;|g" {} +
    # Limpiar espacios dobles generados por el reemplazo
    find api -type f -name "*.php" -exec sed -i "s|\\\Controllers\\\ |\\\Controllers\\\|g" {} +
    find api -type f -name "*.php" -exec sed -i "s|\\\Helpers\\\ |\\\Helpers\\\|g" {} +
    echo "✅ Archivos de la API actualizados."
fi

# Reemplazar enlaces internos entre Repositorios y Servicios dentro de src
find src -type f -name "*.php" -exec sed -i "s|require_once.*Repositories/\(.*\)\.php.*;|use App\\\Repositories\\\ \1;|g" {} +
find src -type f -name "*.php" -exec sed -i "s|require_once.*Services/\(.*\)\.php.*;|use App\\\Services\\\ \1;|g" {} +
echo "✅ Estructura interna de src actualizada."
