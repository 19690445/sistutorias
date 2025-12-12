<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeHelper extends Command
{
    protected $signature = 'make:helper';
    protected $description = 'Crea helpers.php y lo registra automáticamente en Composer';

    public function handle()
    {
        $path = base_path('app/Helpers/helpers.php');

        if (!file_exists($path)) {
            file_put_contents($path, "<?php\n\nif (!function_exists('decodeArray')) {\n    function decodeArray(\$value): array {\n        if (is_array(\$value)) return \$value;\n        if (is_string(\$value)) return json_decode(\$value, true) ?? [];\n        return [];\n    }\n}\n");
            $this->info("Archivo helpers.php creado correctamente en app/Helpers/");
        } else {
            $this->info("El archivo helpers.php ya existe.");
        }

        // Registrar automáticamente en composer.json
        $composerJson = base_path('composer.json');
        $composer = json_decode(file_get_contents($composerJson), true);

        if (!isset($composer['autoload']['files'])) {
            $composer['autoload']['files'] = [];
        }

        if (!in_array('app/Helpers/helpers.php', $composer['autoload']['files'])) {
            $composer['autoload']['files'][] = 'app/Helpers/helpers.php';
            file_put_contents($composerJson, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->info("helpers.php agregado a autoload.files en composer.json");
        } else {
            $this->info("helpers.php ya estaba registrado en composer.json");
        }

        // Ejecutar dump-autoload automáticamente
        exec('composer dump-autoload');
        $this->info("Composer dump-autoload ejecutado exitosamente.");
    }
}
