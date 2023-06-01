<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WorksheetInformation extends Migration
{
    public function up()
    {
        Schema::create('worksheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->text('worksheet_content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('worksheets');
    }
}
