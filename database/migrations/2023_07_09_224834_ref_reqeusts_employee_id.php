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
            ALTER TABLE requests
            ADD CONSTRAINT ref_requests_employee_id
            FOREIGN KEY (employee_id)
            REFERENCES employees(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE requests
            DROP CONSTRAINT IF EXISTS ref_requests_employee_id
        ");
    }
};
