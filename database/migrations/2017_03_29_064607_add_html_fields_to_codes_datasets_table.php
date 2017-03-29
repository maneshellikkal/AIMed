<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHtmlFieldsToCodesDatasetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datasets', function (Blueprint $table) {
            $table->text('description_html')->after('description');
        });

        Schema::table('codes', function (Blueprint $table) {
            $table->text('description_html')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datasets', function (Blueprint $table) {
            $table->dropColumn('description_html');
        });
        Schema::table('codes', function (Blueprint $table) {
            $table->dropColumn('description_html');
        });
    }
}
