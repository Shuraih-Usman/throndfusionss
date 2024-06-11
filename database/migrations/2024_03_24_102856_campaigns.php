<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->double('goal_amount');
            $table->double('current_amount')->nullable()->default(0);
            $table->tinyInteger('type');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            //
        });
    }
};
