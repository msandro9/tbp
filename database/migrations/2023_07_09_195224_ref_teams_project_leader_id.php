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
            ALTER TABLE teams
            ADD CONSTRAINT ref_teams_project_leader_id
            FOREIGN KEY (project_leader_id)
            REFERENCES employees(id)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE teams
            DROP CONSTRAINT IF EXISTS ref_teams_project_leader_id
        ");
    }
};
