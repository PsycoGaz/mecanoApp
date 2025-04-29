<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('piece_detachees', function (Blueprint $table) {
        $table->id(); // Clé primaire
        $table->string('nom'); // Nom de la pièce
        $table->decimal('prix', 10, 2); // Prix de la pièce
        $table->integer('qtestock')->default(0); // Quantité en stock avec une valeur par défaut
        $table->timestamps(); // Colonnes created_at et updated_at
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piece_detachees');
    }
};
