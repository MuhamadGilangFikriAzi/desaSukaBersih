<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_surat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_surat', 100);
            $table->string('code_surat', 100);
            $table->text('body_surat');
            $table->integer('admin_id');
            $table->string('is_active', 10);
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
        Schema::dropIfExists('template_surat');
    }
}
