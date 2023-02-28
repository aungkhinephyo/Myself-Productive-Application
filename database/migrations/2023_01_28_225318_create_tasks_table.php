<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('serial_number')->default(0);
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('priority', ['high', 'medium', 'low']);
            $table->enum('status', ['pending', 'in_progress', 'complete']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
