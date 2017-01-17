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
            $table->foreign('parent_id')
                ->references('circuit_nodes')->on('id')
                ->onDelete('cascade');
            $table->integer('position')->unsigned()->nullable();
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
