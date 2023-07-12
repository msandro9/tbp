<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE TABLE users (
                id bigserial NOT NULL PRIMARY KEY,
                first_name varchar(100) NOT NULL,
                last_name varchar(100) NOT NULL,
                role user_role NOT NULL DEFAULT 'User',
                email varchar(100) NOT NULL UNIQUE,
                email_verified_at timestamp(0) WITHOUT TIME ZONE NULL,
                password varchar(255) NOT NULL,
                remember_token varchar(100),
                created_at timestamp(0) WITHOUT TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at timestamp(0) WITHOUT TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
