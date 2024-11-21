<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesTable extends Migration
{
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->string('cod')->primary();  
            $table->string('nombres');        
            $table->string('email')->unique(); 
            $table->timestamps();              
        });
    }

    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
};
