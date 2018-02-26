<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBilletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billets', function(Blueprint $table) {
            $table->increments('id');
            $table->string('qr')->unique();

            $table->enum('tarif', ['cotisant', 'mineur', 'etudiant', 'plein']);
            $table->enum('seance', [0, 1, 2]);
            $table->string('prenom');
            $table->string('nom');
            $table->boolean('navette')->default(0);

            $table->timestamps();

            $table->integer('transaction_id')->unsigned();
            $table->foreign('transaction_id')
                    ->references('id')
                    ->on('transactions')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            /*
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
             */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billets');
    }
}
