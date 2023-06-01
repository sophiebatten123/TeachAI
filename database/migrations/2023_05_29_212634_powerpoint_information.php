<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PowerpointInformation extends Migration
{
    public function up()
    {
        Schema::create('powerpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->text('powerpoint_content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('powerpoints');
    }
}
