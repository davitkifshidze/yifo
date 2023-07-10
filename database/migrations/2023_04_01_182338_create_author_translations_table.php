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
        Schema::create('author_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('author_id')->unsigned();
            $table->string('locale')->index();

            $table->string('name')->nullable()->default(NULL);
            $table->string('description')->nullable()->default(NULL);
            $table->string('meta_title',254)->nullable()->default(NULL);
            $table->text('meta_keywords')->nullable()->default(NULL);
            $table->text('meta_description')->nullable()->default(NULL);
            $table->string('facebook_meta_title', 254)->nullable()->default(NULL);
            $table->text('facebook_meta_description')->nullable()->default(NULL);
            $table->string('twitter_meta_title', 254)->nullable()->default(NULL);
            $table->text('twitter_meta_description')->nullable()->default(NULL);


            $table->unique(['author_id','locale']);
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_translations');
    }
};
