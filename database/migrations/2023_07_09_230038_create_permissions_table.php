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
            CREATE TABLE permissions (
                id bigserial NOT NULL PRIMARY KEY,
                accepted boolean,
                note TEXT,
                type permission_type NOT NULL,
                request_id BIGINT NOT NULL,
                employee_id BIGINT,
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
        Schema::dropIfExists('permissions');
    }
};
