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
            BEGIN
                IF NEW.accepted = false THEN
                    UPDATE requests
                    SET status = 'Declined'
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
                        SET status = 'Accepted'
                        WHERE id = NEW.request_id;
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
