<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('template_surat_id', 100);
            $table->text('body_surat');
            $table->integer('user_id');
            $table->string('code_surat_printed', 100)->nullable();
            $table->text('body_surat_printed')->nullable();
            $table->integer('last_admin_print')->nullable();
            $table->timestamp("printed_at")->nullable();
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
        Schema::dropIfExists('surat');
    }
}
