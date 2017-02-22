<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCircuitNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circuit_nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('link')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('position')->unsigned()->nullable();
            $table->integer('circuit_id')->unsigned();
            $table->foreign('circuit_id')
                ->references('id')->on('circuit')
                ->onDelete('cascade');
        });

        Schema::table('circuit_nodes', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')->on('circuit_nodes')
                ->onDelete('set null');
        });

        Schema::table('circuits', function (Blueprint $table) {
            $table->foreign('root_node_id')
                ->references('id')->on('circuit_nodes')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('circuit_nodes');

        Schema::table('circuits', function (Blueprint $table) {
            $table->dropForeign('circuits_root_node_id_foreign');
        });
    }
}
