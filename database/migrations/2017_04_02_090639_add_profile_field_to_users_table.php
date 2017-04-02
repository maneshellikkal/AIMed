<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('occupation')->nullable()->after('password');
            $table->string('organization')->nullable()->after('occupation');
            $table->string('github_username')->nullable()->after('organization');
            $table->string('twitter_username')->nullable()->after('github_username');
            $table->string('linkedin_username')->nullable()->after('twitter_username');
            $table->string('website')->nullable()->after('linkedin_username');
            $table->date('dob')->nullable()->after('website');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('occupation');
            $table->dropColumn('organization');
            $table->dropColumn('github_username');
            $table->dropColumn('twitter_username');
            $table->dropColumn('linkedin_username');
            $table->dropColumn('website');
            $table->dropColumn('dob');
        });
    }
}
