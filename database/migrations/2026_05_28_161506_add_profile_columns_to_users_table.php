<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: add profile columns to the users table.
 *
 * Run with:  php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 30)->nullable()->unique()->after('name');
            $table->string('avatar')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('avatar');
            $table->string('gender', 30)->nullable()->after('date_of_birth');
            $table->string('phone', 20)->nullable()->after('gender');
            $table->text('address')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'avatar', 'date_of_birth', 'gender', 'phone', 'address']);
        });
    }
};