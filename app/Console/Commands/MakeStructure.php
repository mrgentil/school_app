<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeStructure extends Command
{
    // Signature de la commande
    protected $signature = 'make:structure {type} {name}';

    // Description de la commande
    protected $description = 'Créer une classe personnalisée (Service, Trait, Policy, etc.)';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $type = ucfirst($this->argument('type')); // Type (e.g., Service, Trait, Policy)
        $name = ucfirst($this->argument('name')); // Nom de la classe
        $namespace = "App\\$type"; // Namespace par défaut

        $directory = app_path($type); // Chemin du répertoire
        $filePath = "$directory/$name.php"; // Chemin complet du fichier

        // Vérifie si le type est valide
        if (!in_array($type, ['Service', 'Trait', 'Policy'])) {
            $this->error("Type non valide. Utilisez 'Service', 'Trait' ou 'Policy'.");
            return;
        }

        // Créer le répertoire si nécessaire
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Vérifie si le fichier existe déjà
        if (File::exists($filePath)) {
            $this->error("$type '$name' existe déjà !");
            return;
        }

        // Générer le contenu de base
        $stub = $this->getStub($type, $name, $namespace);
        File::put($filePath, $stub);

        $this->info("$type '$name' créé avec succès !");
    }

    /**
     * Génère le contenu du fichier en fonction du type.
     *
     * @param string $type
     * @param string $name
     * @param string $namespace
     * @return string
     */
    protected function getStub($type, $name, $namespace)
    {
        switch ($type) {
            case 'Service':
                return "<?php\n\nnamespace $namespace;\n\nclass $name\n{\n    // Implémentez votre logique ici\n}\n";
            case 'Trait':
                return "<?php\n\nnamespace $namespace;\n\ntrait $name\n{\n    // Implémentez votre logique ici\n}\n";
            case 'Policy':
                return "<?php\n\nnamespace $namespace;\n\nuse App\\Models\\Model;\n\nclass $name\n{\n    // Implémentez votre logique ici\n}\n";
        }
    }
}
