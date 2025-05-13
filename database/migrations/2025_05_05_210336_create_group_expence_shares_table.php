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
        Schema::create('group_expence_shares', function (Blueprint $table) {
            $table->id();
            $table->float("amount");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("expence_id");

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("expence_id")->references("id")->on("expences");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_expence_shares');
    }
};
