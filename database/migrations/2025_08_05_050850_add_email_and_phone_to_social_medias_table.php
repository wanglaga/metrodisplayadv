<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('social_media', function (Blueprint $table) {
            $table->string('email')->nullable()->after('link');
            $table->string('phone_number')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('social_media', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone_number']);
        });
    }
};
