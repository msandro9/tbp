<?php

use App\Models\RequestStatus;
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
            CREATE TABLE requests (
                id bigserial NOT NULL PRIMARY KEY,
                start_date date NOT NULL,
                end_date date NOT NULL,
                duration integer NOT NULL,
                status request_status NOT NULL DEFAULT 'Pending',
                employee_id BIGINT NOT NULL,
                created_at timestamp(0) WITHOUT TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at timestamp(0) WITHOUT TIME ZONE NULL DEFAULT CURRENT_TIMESTAMP
                CONSTRAINT check_end_date_after_start_date CHECK (end_date > start_date)
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
