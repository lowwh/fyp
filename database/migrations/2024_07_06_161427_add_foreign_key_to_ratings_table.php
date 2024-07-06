<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToRatingsTable extends Migration
{
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
            // Add the result_id column
            $table->unsignedBigInteger('result_id');

            // Define foreign key constraint
            $table->foreign('result_id')
                ->references('id')
                ->on('results')
                ->onDelete('cascade'); // This ensures that when `results` entry is deleted, related `ratings` entries are also deleted
        });
    }

    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['result_id']);

            // Drop the result_id column if needed
            // $table->dropColumn('result_id'); // Uncomment if you want to drop the column on rollback
        });
    }
}
