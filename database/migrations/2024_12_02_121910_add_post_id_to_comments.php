<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPostIdToComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add post_id column to the comments table and create a foreign key constraint
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id'); // Add the post_id column
            $table->foreign('post_id')            // Define the foreign key relationship
            ->references('id')            // Reference the 'id' column on the 'posts' table
            ->on('post')                  // The name of the posts table
            ->onDelete('cascade');        // If a post is deleted, also delete its comments
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the foreign key and the post_id column if the migration is rolled back
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['post_id']);  // Drop the foreign key
            $table->dropColumn('post_id');     // Drop the post_id column
        });
    }
}
