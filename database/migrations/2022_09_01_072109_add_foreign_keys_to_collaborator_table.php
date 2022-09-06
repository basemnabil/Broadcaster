<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCollaboratorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collaborator', function (Blueprint $table) {
            $table->foreign(['project_id', 'project_edit'], 'collaborator_ibfk_1')->references(['id', 'edit'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['email_id'], 'collaborator_ibfk_3')->references(['id'])->on('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collaborator', function (Blueprint $table) {
            $table->dropForeign('collaborator_ibfk_1');
            $table->dropForeign('collaborator_ibfk_3');
        });
    }
}
