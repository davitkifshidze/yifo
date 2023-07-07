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
        Schema::create('category_translations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id')->unsigned();
            $table->string('locale')->index();

            $table->string('name')->nullable()->default(NULL);
            $table->string('description')->nullable()->default(NULL);
            $table->string('category_meta_title',254)->nullable()->default(NULL);
            $table->text('category_meta_keywords')->nullable()->default(NULL);
            $table->text('category_meta_description')->nullable()->default(NULL);
            $table->string('facebook_meta_title', 254)->nullable()->default(NULL);
            $table->text('facebook_meta_description')->nullable()->default(NULL);
            $table->string('twitter_meta_title', 254)->nullable()->default(NULL);
            $table->text('twitter_meta_description')->nullable()->default(NULL);

            $table->unique(['category_id','locale']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
    }
};

