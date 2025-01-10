<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question'); // Contenu de la question
            $table->string('type'); // Type de question : Multiple Choice, Essay, etc.
            $table->json('options')->nullable(); // Options pour les questions à choix multiples
            $table->string('correct_answer')->nullable(); // Réponse correcte
            $table->boolean('is_active')->default(true); // Statut actif/inactif

            // Clé étrangère optionnelle pour lier la question à un examen spécifique
            $table->foreignId('exam_id')->nullable()->constrained('exams')->onDelete('cascade');

            // Clé étrangère pour associer la question à une matière (si nécessaire)
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');

            // Clé étrangère pour lier la question à son créateur
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
