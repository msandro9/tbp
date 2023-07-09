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
            CREATE TABLE employees (
                id bigserial NOT NULL PRIMARY KEY,
                vacation_days INTEGER NOT NULL DEFAULT 20 CHECK (vacation_days >= 0),
                team_id BIGINT
            ) INHERITS (users)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
