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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->dateTime('finished_at')->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->foreignId('category_id')->nullable()->constrained("categories")->onDelete('cascade');
            $table->foreignId('project_id')->constrained("projects")->onDelete('cascade');
            $table->foreignId('column_id')->constrained("columns")->onDelete('cascade');
            $table->foreignId('created_by')->constrained("users")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
