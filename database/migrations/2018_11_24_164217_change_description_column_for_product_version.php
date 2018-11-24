<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDescriptionColumnForProductVersion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('app.database.dbNames.product_versions');
        $columns = [
            'description' => config('app.database.dbColumnLengths.' . $tableName . '.description'),
        ];

        Schema::table($tableName, function (Blueprint $table) use ($columns) {
            $table->string('description', $columns['description'])->change();
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

        Schema::table($tableName, function (Blueprint $table) {
            $table->text('description')->change();
        });
    }
}
