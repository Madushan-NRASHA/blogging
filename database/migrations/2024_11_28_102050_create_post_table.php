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
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('u_id');
            $table->unsignedBigInteger('mainctg_id');
            $table->unsignedBigInteger('subctg_id');
            $table->text('title');
            $table->text('content');
            $table->text('images');
            $table->text('video');
            $table->enum('status', ['Approve', 'Reject', 'Pending'])->nullable()->default(null);
            $table->timestamps();

            $table->foreign('u_id')->references('id')->on('users');
            $table->foreign('mainctg_id')->references('id')->on('category');
            $table->foreign('subctg_id')->references('id')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
        $table->enum('status', ['Approve', 'Reject', 'Pending'])->default('pending')->change();
    }
};
