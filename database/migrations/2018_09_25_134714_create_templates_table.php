<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source_id');
            $table->string('name');
            $table->string('type', 30);
            $table->mediumText('description')->nullable();
            $table->string('url')->nullable();
            $table->string('filename');
            $table->text('parameters')->nullable();
            $table->text('positions')->nullable();
            $table->char('active', 'N');
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
        Schema::dropIfExists('templates');
    }
}
