<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_surat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_surat', 100)->nullable();
            $table->text('kebutuhan');
            $table->text('body_surat');
            $table->text('admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameter_surat');
    }
}
