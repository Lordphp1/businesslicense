<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 40)->nullable()->after('email');
            $table->string('country', 80)->nullable()->after('phone');
            $table->string('company')->nullable()->after('country');
            $table->string('investor_type', 30)->nullable()->after('company')
                ->comment('individual|company|fund|advisor');
            $table->timestamp('onboarding_completed_at')->nullable()->after('investor_type');
        });

        Schema::table('enquiries', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')
                ->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'country', 'company', 'investor_type', 'onboarding_completed_at']);
        });
    }
};
