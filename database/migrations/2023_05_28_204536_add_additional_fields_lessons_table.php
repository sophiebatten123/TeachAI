<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('objective')->nullable();
            $table->text('recap_activity')->nullable();
            $table->text('teaching')->nullable();
            $table->text('practice')->nullable();
            $table->text('exit_ticket')->nullable();
            $table->text('worksheet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'objective',
                'recap_activity',
                'teaching',
                'practice',
                'exit_ticket',
                'worksheet',
            ]);
        });
    }
}
