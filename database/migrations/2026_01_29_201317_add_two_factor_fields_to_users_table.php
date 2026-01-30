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
            $table->boolean('two_factor_enabled')->default(false)->after('status');
            $table->string('two_factor_type')->nullable()->after('two_factor_enabled');
            $table->text('two_factor_secret')->nullable()->after('two_factor_type');
            $table->json('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->string('two_factor_email_code')->nullable()->after('two_factor_recovery_codes');
            $table->datetime('two_factor_email_expires_at')->nullable()->after('two_factor_email_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_enabled',
                'two_factor_type',
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_email_code',
                'two_factor_email_expires_at'
            ]);
        });
    }
};