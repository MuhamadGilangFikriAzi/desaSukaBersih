<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateSuratDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_surat_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('template_surat_id');
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
        Schema::dropIfExists('template_surat_detail');
    }
}