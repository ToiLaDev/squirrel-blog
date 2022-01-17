<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->foreignId('owner_id')->index()->constrained('employees');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->text('excerpt')->nullable();
            $table->integer('_lft')->nullable()->index();
            $table->integer('_rgt')->nullable()->index();
            $table->integer('parent_id')->nullable()->index();
            //$table->tinyInteger('order')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['_lft', '_rgt']);
        });
        Schema::create('blog_categories_posts', function (Blueprint $table) {
            $table->foreignId('post_id')->index()->constrained('blog_posts');
            $table->foreignId('category_id')->index()->constrained('blog_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('blog_categories_posts');
    }
}
