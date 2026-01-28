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
        Schema::table('orders', function (Blueprint $table) {

            // Rider assignment
            $table->foreignId('rider_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->nullOnDelete();

            // Earnings fields
            $table->decimal('delivery_fee', 10, 2)->default(0)->after('total');
            $table->decimal('tip', 10, 2)->default(0)->after('delivery_fee');

            // Delivery lifecycle
            $table->timestamp('assigned_at')->nullable()->after('status');
            $table->timestamp('picked_up_at')->nullable()->after('assigned_at');
            $table->timestamp('delivered_at')->nullable()->after('picked_up_at');

            // Optional: distance for earnings page table
            $table->decimal('distance_km', 8, 2)->nullable()->after('tip');

            // Note: we will reuse your existing 'status' column
            // but we will start using: Pending | Assigned | Picked Up | Delivered | Cancelled
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('rider_id');
            $table->dropColumn([
                'delivery_fee',
                'tip',
                'assigned_at',
                'picked_up_at',
                'delivered_at',
                'distance_km',
            ]);
        });
    }
};
