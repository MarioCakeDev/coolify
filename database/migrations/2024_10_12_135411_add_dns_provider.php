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
        Schema::create('dns_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256)->unique();
            $table->string('type', 64);
            $table->json('config');
        });

        Schema::create('server_dns_providers', function (Blueprint $table) {

            $table->foreignId('server_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('dns_provider_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('dns_record_type');
            $table->string('dns_record_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_dns_providers');
        Schema::dropIfExists('dns_providers');
    }
};
