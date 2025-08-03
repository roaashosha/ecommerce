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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name",50);
            $table->foreignId("category_id")->constrained();
            $table->foreignId("color_id")->constrained();
            $table->foreignId("size_id")->constrained();
            $table->text("desc");
            $table->integer("price");
            $table->string("img",100);
            $table->date("production_date");
            $table->date("expire_date");
            $table->integer("offer");
            $table->enum('offer_type',["%","-"]);
            $table->integer("offer_price");
            $table->integer("start_price");
            $table->integer("end_price");
            $table->boolean("active")->default(1);
            $table->boolean("is_offer");
            $table->integer("child_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
