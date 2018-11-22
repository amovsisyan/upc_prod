<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('app.database.dbNames.product_versions');
        $productTableName = config('app.database.dbNames.products');
        $categoriesTableName = config('app.database.dbNames.categories');
        $brandsTableName = config('app.database.dbNames.brands');

        $columns = [
            'title' => config('app.database.dbColumnLengths.' . $tableName . '.title'),
            'active' => config('app.database.dbColumnLengths.' . $tableName . '.active'),
        ];

        Schema::create($tableName, function (Blueprint $table) use ($productTableName, $categoriesTableName, $brandsTableName, $columns) {
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on($productTableName)
                ->onDelete('cascade');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on($categoriesTableName)
                ->onDelete('cascade');

            $table->integer('brand_id')->unsigned();
            $table->foreign('brand_id')
                ->references('id')
                ->on($brandsTableName)
                ->onDelete('cascade');

            $table->string('title', $columns['title']);
            $table->text('description');
            $table->integer('width')->unsigned();
            $table->integer('height')->unsigned();
            $table->integer('length')->unsigned();
            $table->integer('weight')->unsigned();
            $table->enum('active', $columns['active']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = config('app.database.dbNames.product_versions');

        Schema::dropIfExists($tableName);
    }
}
