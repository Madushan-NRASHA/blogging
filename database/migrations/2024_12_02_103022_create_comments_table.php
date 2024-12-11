<?php

// database/migrations/2024_12_02_103022_create_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Automatically creates an unsignedBigInteger id
            $table->unsignedBigInteger('post_id'); // Foreign key column
            $table->string('name');
            $table->string('email');
//            $table->string('website')->nullable();
            $table->enum('status', ['Approve', 'Reject', 'Pending'])->nullable()->default(null);
            $table->text('comment');
            $table->timestamps();

            // Foreign key constraint linking post_id to posts table
            $table->foreign('post_id')
                ->references('id')->on('post')
                ->onDelete('cascade'); // Automatically delete comments when a post is deleted
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
        $table->enum('status', ['Approve', 'Reject', 'Pending'])->default('pending')->change();
    }
}
