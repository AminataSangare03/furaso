<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->string('creneau')->nullable()->after('zone_livraison');
        });

        Schema::table('livraisons', function (Blueprint $table) {
            $table->string('livreur_telephone')->nullable()->after('livreur');
            $table->dateTime('date_livraison_prevue')->nullable()->after('statut');
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('creneau');
        });

        Schema::table('livraisons', function (Blueprint $table) {
            $table->dropColumn(['livreur_telephone', 'date_livraison_prevue']);
        });
    }
};
