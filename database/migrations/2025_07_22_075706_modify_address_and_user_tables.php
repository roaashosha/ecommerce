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
        Schema::table('addresses',function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
