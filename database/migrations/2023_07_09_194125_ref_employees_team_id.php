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
            ALTER TABLE employees
            ADD CONSTRAINT ref_employees_team_id
            FOREIGN KEY (team_id)
            REFERENCES teams(id)
            ON DELETE RESTRICT
            ON UPDATE CASCADE
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE employees
            DROP CONSTRAINT IF EXISTS ref_employees_team_id
        ");
    }
};
