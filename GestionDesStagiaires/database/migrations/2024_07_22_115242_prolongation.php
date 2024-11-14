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
        Schema::create('prolongation', function (Blueprint $table) {
            $table->id();
            $table->string('motif')->default('');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->date('old_date_fin');
            $table->unsignedBigInteger('id_stag');
            $table->unsignedBigInteger('old_enc');
            $table->unsignedBigInteger('old_pers');
            $table->unsignedBigInteger('id_pers');
            $table->unsignedBigInteger('id_enc');
            $table->foreign('id_stag')->references('id')->on('stagiaires')->onDelete('cascade');
            $table->foreign('old_enc')->references('id')->on('encadrants')->onDelete('cascade');
            $table->foreign('old_pers')->references('id')->on('personnel')->onDelete('cascade');
            $table->foreign('id_pers')->references('id')->on('personnel')->onDelete('cascade');
            $table->foreign('id_enc')->references('id')->on('encadrants')->onDelete('cascade');

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
        //
    }
};
