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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->foreignId('address_id')->nullable()->constrained();
            $table->string('email',200)->nullable()->unique();
            $table->string('username',50)->nullable()->unique();
            $table->string('phone',11)->nullable();
            $table->date('birth_date')->nullable();
            $table->boolean("theme")->default(0);
            $table->string("lang",2)->default('en');
            $table->string("img",100)->nullable();
            $table->enum("gender",["male","female"])->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',60)->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('remember_me')->default(0);
            $table->boolean('agreement_policies')->default(0);
            $table->foreignId('role_id')->nullable()->constrained();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
