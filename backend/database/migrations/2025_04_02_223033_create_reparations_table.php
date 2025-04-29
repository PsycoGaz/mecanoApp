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
    Schema::create('reparations', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->decimal('cout', 10, 2);
        $table->integer('km');
        $table->foreignId('voiture_id')->constrained()->onDelete('cascade');
        $table->foreignId('technicien_id')->constrained('employes')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reparations');
    }
};
