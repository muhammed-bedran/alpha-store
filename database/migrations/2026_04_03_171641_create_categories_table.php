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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // $table->string('name',15);
            $table->string('name',15); // 255
            $table->string('slug',15)->unique();
            
       // text
       //text
            $table->text('description')->nullable(); // 65535
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }
    //muhammed_19
    // id
//create_at, update_at
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
