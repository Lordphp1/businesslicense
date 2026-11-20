<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('title');
            $table->text('summary');
            $table->foreignId('industry_id')->nullable()->constrained('industries')->nullOnDelete();
            $table->string('location')->nullable();
            $table->string('investment_min')->nullable()->comment('Display label, e.g. currency-free provisional range');
            $table->string('investment_max')->nullable()->comment('Display label, provisional');
            $table->string('status')->default('draft')->index()->comment('draft|published|closed');
            $table->boolean('is_featured')->default(false)->index();
            $table->string('image_key')->nullable()->comment('Key in config/assets.php');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_opportunities');
    }
};
