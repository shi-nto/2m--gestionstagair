<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('cin');
            $table->boolean('gender');
            $table->string('formation');
            $table->string('gsm');
            $table->string('nature_stage');
            $table->string('theme');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->unsignedBigInteger('id_enc');
            $table->unsignedBigInteger('id_pers');
            $table->timestamps();
            $table->foreign('id_pers')->references('id')->on('personnel')->onDelete('cascade');
            $table->foreign('id_enc')->references('id')->on('encadrants')->onDelete('cascade');
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
};
