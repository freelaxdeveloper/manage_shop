<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->integer('count');
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();

            $table->unique(['category_id', 'month', 'year']);

            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->onDelete('cascade');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('plan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');

        Schema::table('categories', function (Blueprint $table) {
            $table->integer('plan')->default(0)->after('name');
        });
    }
}
