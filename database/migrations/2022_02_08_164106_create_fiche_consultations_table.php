<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicheConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiche_consultations', function (Blueprint $table) {
            $table->id();
            $table->double('temperature');
            $table->string('typeMaladie');
            $table->string('descriptionMaladie');
            $table->string('antecedentMedicaux');
            $table->string('traitementInitial');
            $table->string('groupSangin')->nullable();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('fiche_consultations');
    }
}