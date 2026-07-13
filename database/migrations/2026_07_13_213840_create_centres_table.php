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
        Schema::create('centres', function (Blueprint $table) {
            $table->id();
            $table->string('nom_centre');
            $table->string('ville_centre');
            $table->string('quartier_centre')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->foreignId('cree_par_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('valide_par_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('date_validation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centres');
    }
};
