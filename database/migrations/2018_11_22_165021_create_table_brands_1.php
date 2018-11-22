<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBrands1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('app.database.dbNames.brands');
        $columnLengths = [
            'name' => config('app.database.dbColumnLengths.' . $tableName . '.name'),
        ];

        Schema::create($tableName, function (Blueprint $table) use($columnLengths) {
            $table->increments('id');
            $table->string('name', $columnLengths['name']);
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
        $tableName = config('app.database.dbNames.brands');

        Schema::dropIfExists($tableName);
    }
}
