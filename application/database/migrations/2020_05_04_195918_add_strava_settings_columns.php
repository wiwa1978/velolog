<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStravaSettingsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('strava_settings', function (Blueprint $table) {
            $table->string('return_code')->after('strava_authorised')->nullable();
            $table->string('access_token')->after('return_code')->nullable();
            $table->string('refresh_token')->after('access_token')->nullable();
            $table->string('expires_at')->after('refresh_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('strava_settings', function (Blueprint $table) {
            //
        });
    }
}
