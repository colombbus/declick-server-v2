<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCircuitNodesCircuitIdForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('circuit_nodes', function (Blueprint $table) {
            $table->integer('circuit_id')->unsigned();
            $table->foreign('circuit_id')
                ->references('id')->on('circuits')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('circuit_nodes', function (Blueprint $table) {
            $table->dropForeign('circuit_nodes_circuit_id_foreign');
            $table->dropColumn('circuit_id');
        });
    }
}
