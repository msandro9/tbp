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
                employee_id BIGINT,
                created_at timestamp(0) WITHOUT TIME ZONE NULL,
                updated_at timestamp(0) WITHOUT TIME ZONE NULL
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
