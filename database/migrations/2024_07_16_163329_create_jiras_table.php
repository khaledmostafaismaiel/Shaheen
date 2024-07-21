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
        Schema::create('jiras', function (Blueprint $table) {
            $table->id();
            $table->enum("type", ["cloud_based", "server_based"]);
            $table->string("name");
            $table->string("domain");
            $table->string("user_name");
            $table->string("password");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jiras');
    }
};
