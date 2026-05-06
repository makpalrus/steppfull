<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('birth_year')->nullable()->after('email');
        $table->text('work_experience')->nullable()->after('birth_year');
    });
}
public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['birth_year', 'work_experience']);
    });
}
};
