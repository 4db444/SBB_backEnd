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
        Schema::create('group_expense_shares', function (Blueprint $table) {
            $table->id();
            $table->float("amount");
            $table->unsignedBigInteger("user_id");
            $table->ulid("expense_id");

            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("expense_id")->references("id")->on("expenses");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_expense_shares');
    }
};
