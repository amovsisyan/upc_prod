<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('app.database.dbNames.attachments');
        $productTableName = config('app.database.dbNames.products');

        $columns = [
            'path' => config('app.database.dbColumnLengths.' . $tableName . '.path'),
        ];

        Schema::create($tableName, function (Blueprint $table) use ($productTableName, $columns) {
            $table->increments('id');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')
                ->references('id')
                ->on($productTableName)
                ->onDelete('cascade');

            $table->string('path', $columns['path']);

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
        $tableName = config('app.database.dbNames.attachments');

        Schema::dropIfExists($tableName);
    }
}
