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
        Schema::create('news_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('news_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title',254)->nullable()->default(NULL);
            $table->text('tag')->nullable()->default(NULL);
            $table->text('intro')->nullable()->default(NULL);
            $table->text('text')->nullable()->default(NULL);
            $table->string('image',254)->nullable()->default(NULL);
            $table->text('thumb_image')->nullable()->default(NULL);
            $table->string('news_meta_title',254)->nullable()->default(NULL);
            $table->text('news_meta_keywords')->nullable()->default(NULL);
            $table->text('news_meta_description')->nullable()->default(NULL);
            $table->string('facebook_meta_title', 254)->nullable()->default(NULL);
            $table->text('facebook_meta_description')->nullable()->default(NULL);
            $table->string('twitter_meta_title', 254)->nullable()->default(NULL);
            $table->text('twitter_meta_description')->nullable()->default(NULL);

            $table->unique(['news_id','locale']);
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_translations');
    }
};

