<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permits', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('name');
            $table->string('authority')->nullable()->comment('Issuing authority named for the investor');
            $table->string('summary', 300)->nullable();
            $table->decimal('fee', 12, 2)->nullable()->comment('Agency service fee; statutory fees are separate');
            $table->string('currency', 3)->default('USD');
            $table->string('turnaround', 80)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permits');
    }
};
