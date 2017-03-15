<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('owner_id')->unsigned();
            $table->foreign('owner_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->boolean('is_exercise')->default(false);
            $table->boolean('is_public')->default(false);
            $table->integer('scene_height')->unsigned()->nullable();
            $table->integer('scene_width')->unsigned()->nullable();
            $table->integer('entry_point_id')->unsigned()->nullable();
            $table->longText('description');
            $table->longText('instructions');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('default_project_id')
                ->references('id')->on('projects')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_default_project_id_foreign');
        });

        Schema::drop('projects');
    }
}
