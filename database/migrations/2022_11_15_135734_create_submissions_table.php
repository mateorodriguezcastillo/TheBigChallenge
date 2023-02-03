<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            //foreign key to the user table named patient_id
            $table->foreignId('patient_id')->constrained('users');
            //foreign key to the user table named doctor_id (doctor may not taken the submission so it can be null)
            $table->foreignId('doctor_id')->nullable()->constrained('users');
            $table->string('title');
            $table->string('symptoms');
            //status can be pending, approved, rejected
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
};
