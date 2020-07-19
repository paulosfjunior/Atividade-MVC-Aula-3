<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsCepToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('zipcode', 15)->nullable()->after('email');
            $table->string('address')->nullable()->after('zipcode');
            $table->string('number')->nullable()->after('address');
            $table->string('neighborhood')->nullable()->after('number');
            $table->string('city')->nullable()->after('neighborhood');
            $table->string('state')->nullable()->after('city');
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
            $table->dropColumn(['zipcode', 'address', 'number', 'neighborhood', 'city', 'state']);
        });
    }
}
