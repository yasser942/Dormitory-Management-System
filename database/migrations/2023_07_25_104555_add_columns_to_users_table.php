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
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name'); // Add last_name column
            $table->string('phone')->nullable(); // Add phone column and make it nullable
            $table->text('address')->nullable(); // Add address column and make it nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name'); // Drop last_name column
            $table->dropColumn('phone'); // Drop phone column
            $table->dropColumn('address'); // Drop address column
        });
    }
};
