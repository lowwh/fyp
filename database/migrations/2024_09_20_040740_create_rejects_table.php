<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectsTable extends Migration
{
    public function up()
    {
        Schema::create('rejects', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->foreignId('result_id')->constrained('results')->onDelete('cascade');  // Foreign key to 'results' table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to 'users' table
            $table->string('reason')->nullable();  // Optional reason for rejection
            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('rejects');
    }
}
