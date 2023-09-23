<?php namespace Waka\Phpw\Updates;

use Winter\Storm\Database\Schema\Blueprint;
use Winter\Storm\Database\Updates\Migration;
use Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('waka_phpw_documents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('map_key')->nullable();
            $table->string('path')->nullable();
            $table->string('output_name')->nullable();
            $table->json('config')->nullable();
            //reorder
            $table->integer('sort_order')->default(0);
            //softDelete
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waka_phpw_documents');
    }
}