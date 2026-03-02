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
        // Schema::create('reporte_boletos_view', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        if(!Schema::hasTable('lenguas_view')){
            DB::statement("
                CREATE VIEW lenguas_view AS (
                    SELECT
                    'ethnologue' as clen_base,   clen_id as clen_id,   clen_lengua as clen_lengua, clen_code as clen_code, clen_localidad as clen_localidad, clen_altnames as clen_nombres, clen_autonimias as clen_autonimia
                    FROM cat_lenguas

                    UNION

                    SELECT
                    'Inali' as clen_base, clen2_id as clen_id, clen2_lengua as clen_lengua, clen2_code as clen_code, clen2_localidad as clen_localidad, clen2_lengua as clen_nombres, clen2_autonimia as clen_autonimia
                    FROM cat_lenguas_inali
                )
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('reporte_boletos_view');
        DB::statement('DROP VIEW IF EXISTS lenguas_view CASCADE');
    }
};
