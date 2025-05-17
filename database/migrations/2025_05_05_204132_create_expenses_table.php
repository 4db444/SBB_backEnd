<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->float("amount");
            $table->text("description");
            
            $table->unsignedBigInteger("expense_category_id");
            $table->unsignedBigInteger("group_id");
            $table->unsignedBigInteger("user_id");

            $table->foreign("expense_category_id")->references("id")->on("expense_categories");
            $table->foreign("group_id")->references("id")->on("groups");
            $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
