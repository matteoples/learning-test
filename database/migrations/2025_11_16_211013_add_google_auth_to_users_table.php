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
            $table->longText('google_id')->nullable()->after('password');
            $table->longText('google_token')->nullable()->after('google_id');
            $table->longText('google_refresh_token')->nullable()->after('google_token');
            
            DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'google_id',
                'google_token',
                'google_refresh_token',
            ]);

            DB::statement('ALTER TABLE users MODIFY password VARCHAR(255) NOT NULL');
        });
    }
};
