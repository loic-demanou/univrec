<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('decrees_establishing')->nullable();
            $table->string('authorization_to_open')->nullable();
            $table->string('web_site')->nullable();
            $table->string('region')->nullable();
            $table->string('department')->nullable();
            $table->string('location_site')->nullable();
            $table->foreignId('user_id')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('universities');
    }
}
