<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParameterSuratDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameter_surat_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parameter_surat_id');
            $table->string('label', 100)->nullable();
            $table->string('tag');
            $table->string('input_type');
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
        Schema::dropIfExists('parameter_surat_detail');
    }
}