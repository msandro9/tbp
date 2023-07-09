<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION check_team_leader_role()
            RETURNS TRIGGER AS $$
            BEGIN
                IF NEW.team_leader_id IS NOT NULL THEN
                    IF NOT EXISTS (
                        SELECT 1
                        FROM employees
                        WHERE id = NEW.team_leader_id AND role = \'Team Leader\'
                    ) THEN
                        RAISE EXCEPTION \'The employee assigned as team leader must have the role "Team Leader".\';
                    END IF;
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::unprepared('
            CREATE TRIGGER before_insert_team_leader
            BEFORE INSERT ON teams
            FOR EACH ROW
            EXECUTE FUNCTION check_team_leader_role();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS before_insert_team_leader ON teams;');
        DB::unprepared('DROP FUNCTION IF EXISTS check_team_leader_role();');
    }
};
