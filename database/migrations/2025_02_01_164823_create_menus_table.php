<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('language', 255);  // language column (varchar)
            $table->unsignedBigInteger('category_id')->default(0);  // category_id column, foreign key reference
            $table->text('name');  // name column (text)
            $table->text('description')->nullable();  // description column (nullable text)
            $table->text('image')->nullable();  // image column (nullable text)
            $table->string('price_half', 255)->nullable();  // price_half column (varchar, nullable)
            $table->string('price_full', 255)->nullable();  // price_full column (varchar, nullable)
            $table->integer('order')->default(0);  // order column (default 0)
            $table->enum('status', ['1', '2'])->default('1')->comment('1->Active, 2->NotActive');  // status column (enum)
            $table->string('menu_type', 255)->nullable();  // menu_type column (varchar, nullable)
            $table->timestamps();  // created_at and updated_at columns (timestamps)
        });
    }

    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
