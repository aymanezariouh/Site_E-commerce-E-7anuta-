<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if we need to add moderation_status column
        $hasModStatus = Schema::hasColumn('products', 'moderation_status');
        
        if (!$hasModStatus) {
            // Add moderation_status column
            Schema::table('products', function (Blueprint $table) {
                $table->enum('moderation_status', ['pending', 'approved', 'rejected'])
                    ->default('approved')
                    ->after('is_active');
            });
            
            // Copy current status values to moderation_status
            DB::statement("UPDATE products SET moderation_status = status WHERE status IN ('pending', 'approved', 'rejected')");
        }
        
        // Change status column to VARCHAR temporarily
        DB::statement("ALTER TABLE products MODIFY COLUMN status VARCHAR(20) DEFAULT 'published'");
        
        // Update all values to 'published'
        DB::statement("UPDATE products SET status = 'published'");
        
        // Now change to the correct ENUM
        DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM('draft', 'published', 'archived') DEFAULT 'published'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'approved'");
    }
};
