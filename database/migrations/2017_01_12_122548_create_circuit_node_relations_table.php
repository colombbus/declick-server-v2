<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCircuitNodeRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circuit_node_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->foreign('parent_id')
                ->references('circuit_nodes')->on('id')
                ->onDelete('cascade');
            $table->integer('child_id');
            $table->foreign('child_id')
                ->references('circuit_nodes')->on('id')
                ->onDelete('cascade');
            $table->integer('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('circuit_node_relations');
    }
}
