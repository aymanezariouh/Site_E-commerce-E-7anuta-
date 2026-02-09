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
        Schema::table('products', function (Blueprint $table) {
            $table->enum('moderation_status', ['pending', 'approved', 'rejected'])->default('approved')->after('is_active');
            $table->text('moderation_reason')->nullable()->after('moderation_status');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->enum('moderation_status', ['pending', 'approved', 'rejected'])->default('pending')->after('is_approved');
            $table->text('moderation_reason')->nullable()->after('moderation_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['moderation_status', 'moderation_reason']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['moderation_status', 'moderation_reason']);
        });
    }
};
