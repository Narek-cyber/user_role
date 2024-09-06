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
            $table->string('lastname');
            $table->string('phone');
            $table->date('date_of_birth');
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->string('invite_token', 64)->nullable();
            $table->string('invite_link')->nullable();
            $table->boolean('invited')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'invited',
                'invite_link',
                'invite_token',
                'role',
                'date_of_birth',
                'phone',
                'lastname',
            ]);
        });
    }
};
