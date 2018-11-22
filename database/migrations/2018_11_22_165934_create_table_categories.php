<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('app.database.dbNames.categories');
        $columnLengths = [
            'name' => config('app.database.dbColumnLengths.' . $tableName . '.name'),
        ];

        Schema::create('categories', function (Blueprint $table) use ($tableName, $columnLengths) {
            $table->increments('id');
            $table->string('name', $columnLengths['name']);

            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')
                ->references('id')
                ->on($tableName)
                ->onDelete('set null');

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
        $tableName = config('app.database.dbNames.categories');

        Schema::dropIfExists($tableName);
    }
}
