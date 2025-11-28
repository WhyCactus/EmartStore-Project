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
        Schema::table('login_logs', function (Blueprint $table) {
            $table->string('login_method')->default('web')->after('user_agent');
            $table->boolean('is_successful')->default(true)->after('login_method');
            $table->string('failure_reason')->nullable()->after('is_successful');

            $table->index(['user_id', 'is_successful']);
            $table->index('logged_in_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
