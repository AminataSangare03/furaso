<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('ville')->nullable();
            $table->string('region')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('partenaire')->default(true);
            $table->timestamps();
        });

        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date_naissance')->nullable();
            $table->string('sexe')->nullable();
            $table->string('groupe_sanguin')->nullable();
            $table->string('personne_urgence')->nullable();
            $table->string('telephone_urgence')->nullable();
            $table->timestamps();
        });

        Schema::create('pharmaciens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pharmacie_id')->nullable()->constrained('pharmacies')->nullOnDelete();
            $table->string('numero_ordre')->nullable();
            $table->string('specialite')->nullable();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('medicaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('pharmacie_id')->nullable()->constrained('pharmacies')->nullOnDelete();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('dosage')->nullable();
            $table->string('laboratoire')->nullable();
            $table->decimal('prix', 12, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->boolean('ordonnance_obligatoire')->default(false);
            $table->text('effets_secondaires')->nullable();
            $table->text('conseils_utilisation')->nullable();
            $table->string('maladie')->nullable();
            $table->date('date_expiration')->nullable();
            $table->timestamps();
        });

        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('pharmacie_id')->nullable()->constrained('pharmacies')->nullOnDelete();
            $table->string('fichier'); // chemin photo ou PDF
            $table->string('type')->default('image'); // image | pdf
            $table->string('statut')->default('en_attente'); // en_attente | validee | refusee
            $table->text('commentaire_pharmacien')->nullable();
            $table->timestamp('date_envoi')->nullable();
            $table->timestamps();
        });

        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('pharmacie_id')->nullable()->constrained('pharmacies')->nullOnDelete();
            $table->foreignId('ordonnance_id')->nullable()->constrained('ordonnances'); // NO ACTION (SQL Server cascade path)
            $table->decimal('montant_total', 12, 2)->default(0);
            $table->decimal('frais_livraison', 12, 2)->default(0);
            $table->string('statut')->default('en_attente'); // en_attente | confirmee | preparee | expediee | livree | annulee
            $table->string('mode_paiement')->nullable(); // livraison | orange_money | moov_money | carte
            $table->string('adresse_livraison')->nullable();
            $table->string('zone_livraison')->nullable();
            $table->timestamps();
        });

        Schema::create('details_commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->cascadeOnDelete();
            $table->foreignId('medicament_id')->nullable()->constrained('medicaments')->nullOnDelete();
            $table->string('nom_medicament')->nullable();
            $table->integer('quantite')->default(1);
            $table->decimal('prix', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->cascadeOnDelete();
            $table->decimal('montant', 12, 2)->default(0);
            $table->string('methode')->nullable();
            $table->string('statut')->default('en_attente'); // en_attente | paye | echoue
            $table->string('reference')->nullable();
            $table->timestamps();
        });

        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->cascadeOnDelete();
            $table->string('livreur')->nullable();
            $table->string('zone')->nullable();
            $table->decimal('frais', 12, 2)->default(0);
            $table->string('statut')->default('en_preparation'); // en_preparation | en_cours | livree
            $table->timestamp('date_livraison')->nullable();
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expediteur_id')->constrained('users'); // NO ACTION (SQL Server cascade path)
            $table->foreignId('destinataire_id')->constrained('users'); // NO ACTION (SQL Server cascade path)
            $table->text('message');
            $table->boolean('lu')->default(false);
            $table->timestamp('date_envoi')->nullable();
            $table->timestamps();
        });

        Schema::create('notifications_furaso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('titre');
            $table->text('contenu')->nullable();
            $table->string('lien')->nullable();
            $table->boolean('lu')->default(false);
            $table->timestamps();
        });

        Schema::create('favoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('medicament_id')->constrained('medicaments')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'medicament_id']);
        });

        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('pharmacie_id')->constrained('pharmacies')->cascadeOnDelete();
            $table->unsignedTinyInteger('note')->default(5);
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
        Schema::dropIfExists('favoris');
        Schema::dropIfExists('notifications_furaso');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('livraisons');
        Schema::dropIfExists('paiements');
        Schema::dropIfExists('details_commandes');
        Schema::dropIfExists('commandes');
        Schema::dropIfExists('ordonnances');
        Schema::dropIfExists('medicaments');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('pharmaciens');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('pharmacies');
    }
};
