<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id(); // Crée la colonne 'id' comme clé primaire
            $table->string('filename')->nullable(); // Colonne 'filename', peut être nulle
            $table->string('filepath'); // Colonne 'filepath', obligatoire
            $table->unsignedBigInteger('user_id'); // Colonne 'user_id', peut être nulle
            $table->unsignedBigInteger('group_id')->nullable(); // Colonne 'group_id', ajoutée comme clé étrangère, peut être nulle
            $table->timestamps(); // Colonnes 'created_at' et 'updated_at'
        
            // Définitions des clés étrangères
            $table->foreign('group_id')->references('id')->on('groupes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
