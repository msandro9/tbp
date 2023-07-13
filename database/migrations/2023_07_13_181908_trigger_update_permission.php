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
        DB::unprepared("
            CREATE OR REPLACE FUNCTION update_request_status()
            RETURNS TRIGGER AS $$
            DECLARE
                total_permissions INTEGER;
                accepted_permissions INTEGER;
                request_duration INTEGER;
                request_employee_id INTEGER;
            BEGIN
                IF NEW.accepted = false THEN
                    UPDATE requests
                    SET status = 'Declined',
                    updated_at = CURRENT_TIMESTAMP
                    WHERE id = NEW.request_id;
                ELSE
                    SELECT COUNT(*) INTO total_permissions
                    FROM permissions
                    WHERE request_id = NEW.request_id;

                    SELECT COUNT(*) INTO accepted_permissions
                    FROM permissions
                    WHERE request_id = NEW.request_id AND accepted = true;

                    IF accepted_permissions = total_permissions THEN
                        UPDATE requests
                        SET status = 'Accepted',
                        updated_at = CURRENT_TIMESTAMP
                        WHERE id = NEW.request_id;

                        SELECT duration, employee_id INTO request_duration, request_employee_id
                        FROM requests
                        WHERE id = NEW.request_id;

                        UPDATE employees
                        SET vacation_days = vacation_days - request_duration
                        WHERE id = request_employee_id;
                    END IF;
                END IF;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            CREATE TRIGGER permissions_update_trigger
            AFTER UPDATE ON permissions
            FOR EACH ROW
            EXECUTE FUNCTION update_request_status();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER permissions_update_trigger ON permissions;');
        DB::unprepared('DROP FUNCTION IF EXISTS update_request_status();');
    }
};
