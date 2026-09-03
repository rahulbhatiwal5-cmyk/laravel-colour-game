<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('coupon_id')->nullable()->after('upi_id')->constrained('coupons')->nullOnDelete();
            $table->string('coupon_code')->nullable()->after('coupon_id');
            $table->decimal('coupon_percentage', 5, 2)->nullable()->after('coupon_code');
            $table->decimal('bonus_amount', 12, 2)->default(0)->after('coupon_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropColumn(['coupon_id', 'coupon_code', 'coupon_percentage', 'bonus_amount']);
        });
    }
};