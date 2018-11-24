<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbnauilToattachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('app.database.dbNames.attachments');
        $columns = [
            'thumbnail' => config('app.database.dbColumnLengths.' . $tableName . '.thumbnail'),
        ];

        Schema::table($tableName, function (Blueprint $table) use ($columns) {
            $table->string('thumbnail', $columns['thumbnail'])->nullable()->after('path');
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

        Schema::table($tableName, function (Blueprint $table) {
            Schema::dropIfExists('thumbnail');
        });
    }
}
