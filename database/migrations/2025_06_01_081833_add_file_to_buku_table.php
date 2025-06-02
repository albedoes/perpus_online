<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileToBukuTable extends Migration
{
    public function up()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->string('file')->nullable()->after('image');
        });
    }

    public function down()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('file');
        });
    }
}
