<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug_sort')->nullable();
            $table->string('slug')->unique()->index()->nullable();
            $table->string('type')->default('novel');
            $table->json('description')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('serie_id')->index()->nullable()->after('rights');
            $table->foreign('serie_id')
                ->references('id')
                ->on('series')
                ->nullOnDelete()
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('series');
    }
}
