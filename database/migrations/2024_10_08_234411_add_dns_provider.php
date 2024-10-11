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

        Schema::table('server_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('dns_provider_id')->nullable();
            $table->foreign('dns_provider_id')
                ->references('id')
                ->on('dns_providers')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('server_settings', function (Blueprint $table) {
            $table->dropForeign('server_settings_dns_provider_id_foreign');
            $table->dropColumn('dns_provider_id');
        });

        Schema::dropIfExists('dns_providers');
    }
};
