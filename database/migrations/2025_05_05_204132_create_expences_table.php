<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expences', function (Blueprint $table) {
            $table->id();
            $table->float("amount");
            $table->text("description");
            
            $table->unsignedBigInteger("expence_category_id");
            $table->unsignedBigInteger("group_id");
            $table->unsignedBigInteger("user_id");

            $table->foreign("expence_category_id")->references("id")->on("expence_categories");
            $table->foreign("group_id")->references("id")->on("groups");
            $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expences');
    }
};
