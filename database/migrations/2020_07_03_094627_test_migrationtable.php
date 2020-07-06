<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestMigrationtable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->integer('Id_Customer');
            $table->string('FirstName',45);
            $table->string('SecondName',45);
            $table->string('LastName',45)->nullable();
            $table->string('Company',45);
            $table->string('Adress',150);
            $table->primary('Id_Customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
