<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategoryProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('app.database.dbNames.category_product');
        $productTableName = config('app.database.dbNames.products');
        $categoriesTableName = config('app.database.dbNames.categories');

        Schema::create($tableName, function (Blueprint $table) use ($productTableName, $categoriesTableName) {
            $table->increments('id');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on($categoriesTableName)
                ->onDelete('cascade');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on($productTableName)
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = config('app.database.dbNames.category_product');

        Schema::dropIfExists($tableName);
    }
}
