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
            ALTER TABLE permissions
            ADD CONSTRAINT ref_permissions_request_id
            FOREIGN KEY (request_id)
            REFERENCES requests(id)
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
            DROP CONSTRAINT IF EXISTS ref_permissions_request_id
        ");
    }
};
