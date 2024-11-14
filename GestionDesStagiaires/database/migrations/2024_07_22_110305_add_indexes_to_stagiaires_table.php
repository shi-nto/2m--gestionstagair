<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToStagiairesTable extends Migration
{
    public function up()
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->index('date_debut');
            $table->index('nature_stage');
            $table->index('gender');
        });
    }

    public function down()
    {
        Schema::table('stagiaires', function (Blueprint $table) {
            $table->dropIndex(['date_debut']);
            $table->dropIndex(['nature_stage']);
            $table->dropIndex(['gender']);
        });
    }
}
