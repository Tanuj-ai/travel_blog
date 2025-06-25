<?php

// Rename this file to use today's date
// For example: 2023_06_03_create_trips_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('destination');
            $table->integer('travelers');
            $table->decimal('budget', 10, 2)->nullable();
            $table->json('itinerary')->nullable();
            $table->json('accommodations')->nullable();
            $table->json('transportation')->nullable();
            $table->json('expenses')->nullable();
            $table->json('packing_list')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_public')->default(false);
            $table->json('collaborators')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};

