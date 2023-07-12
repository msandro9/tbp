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
            CREATE OR REPLACE FUNCTION insert_permissions()
            RETURNS TRIGGER AS $$
            DECLARE
                new_request_id BIGINT;
            BEGIN
                new_request_id := NEW.id;
                INSERT INTO permissions (type, request_id)
                VALUES
                ('Project Leader', new_request_id),
                ('Team Leader', new_request_id);
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::unprepared("
            CREATE TRIGGER request_insert_trigger
            AFTER INSERT ON requests
            FOR EACH ROW
            EXECUTE FUNCTION insert_permissions();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS request_insert_trigger ON requests;');
        DB::unprepared('DROP FUNCTION IF EXISTS insert_permissions();');
    }
};
