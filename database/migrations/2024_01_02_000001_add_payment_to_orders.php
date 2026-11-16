<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            $t->string('payment_method')->default('cod')->after('address'); // qris | cod
            $t->string('payment_proof')->nullable()->after('payment_method'); // foto bukti bayar
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            $t->dropColumn(['payment_method', 'payment_proof']);
        });
    }
};
