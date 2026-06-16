<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Medicament;
use App\Models\Patient;
use App\Models\Pharmacie;
use App\Models\Pharmacien;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Pharmacies ----------
        $pharmacies = [
            ['nom' => 'Pharmacie du Fleuve', 'ville' => 'Bamako', 'region' => 'Bamako', 'adresse' => 'Avenue Modibo Keïta', 'telephone' => '+223 20 22 11 11', 'latitude' => 12.6392, 'longitude' => -8.0029],
            ['nom' => 'Pharmacie de l\'Hippodrome', 'ville' => 'Bamako', 'region' => 'Bamako', 'adresse' => 'Rue 224, Hippodrome', 'telephone' => '+223 20 21 22 33', 'latitude' => 12.6500, 'longitude' => -7.9800],
            ['nom' => 'Pharmacie Kati Santé', 'ville' => 'Kati', 'region' => 'Koulikoro', 'adresse' => 'Route de Kati', 'telephone' => '+223 21 27 44 55'],
            ['nom' => 'Pharmacie Ségou Centre', 'ville' => 'Ségou', 'region' => 'Ségou', 'adresse' => 'Quartier Administratif', 'telephone' => '+223 21 32 66 77'],
            ['nom' => 'Pharmacie Sikasso Plus', 'ville' => 'Sikasso', 'region' => 'Sikasso', 'adresse' => 'Centre-ville', 'telephone' => '+223 21 62 88 99'],
        ];
        $pharmacieModels = collect($pharmacies)->map(fn ($p) => Pharmacie::create($p + ['partenaire' => true]));
        $pharmaciePrincipale = $pharmacieModels->first();

        // ---------- Catégories ----------
        $categories = [
            'Antalgiques' => 'Médicaments contre la douleur',
            'Antibiotiques' => 'Traitement des infections bactériennes',
            'Antipaludéens' => 'Traitement et prévention du paludisme',
            'Vitamines & Compléments' => 'Compléments alimentaires et vitamines',
            'Diabète' => 'Traitements pour le diabète',
            'Hypertension' => 'Traitements cardiovasculaires',
            'Digestion' => 'Troubles digestifs',
            'Soins & Hygiène' => 'Produits de soin et d\'hygiène',
        ];
        $catModels = [];
        foreach ($categories as $nom => $desc) {
            $catModels[$nom] = Categorie::create(['nom' => $nom, 'description' => $desc]);
        }

        // ---------- Médicaments ----------
        $medicaments = [
            ['Paracétamol', 'Antalgiques', '500mg', 'Sanofi', 500, 200, false, 'Paludisme, fièvre', 'Maux de tête et fièvre', 'Rare : éruptions cutanées', 'Max 3g/jour chez l\'adulte'],
            ['Ibuprofène', 'Antalgiques', '400mg', 'Pfizer', 750, 120, false, 'Douleurs', 'Anti-inflammatoire et antidouleur', 'Troubles digestifs', 'À prendre au cours des repas'],
            ['Amoxicilline', 'Antibiotiques', '500mg', 'GSK', 1500, 80, true, 'Infections', 'Antibiotique à large spectre', 'Diarrhée, allergies', 'Respecter la durée du traitement'],
            ['Azithromycine', 'Antibiotiques', '250mg', 'Pfizer', 2500, 40, true, 'Infections respiratoires', 'Antibiotique macrolide', 'Nausées', 'Une prise par jour'],
            ['Coartem (Artéméther/Luméfantrine)', 'Antipaludéens', '20/120mg', 'Novartis', 3000, 60, true, 'Paludisme', 'Traitement du paludisme simple', 'Vertiges', 'Suivre la posologie selon le poids'],
            ['Quinine', 'Antipaludéens', '300mg', 'Sanofi', 2000, 35, true, 'Paludisme', 'Antipaludéen', 'Acouphènes', 'Sous surveillance médicale'],
            ['Vitamine C', 'Vitamines & Compléments', '1000mg', 'Bayer', 1200, 150, false, 'Fatigue', 'Renforce le système immunitaire', 'Aucun connu', '1 comprimé par jour'],
            ['Fer + Acide folique', 'Vitamines & Compléments', null, 'UPSA', 1800, 90, false, 'Anémie', 'Supplément pour femmes enceintes', 'Constipation', '1 comprimé par jour'],
            ['Metformine', 'Diabète', '850mg', 'Merck', 2200, 50, true, 'Diabète', 'Antidiabétique oral', 'Troubles digestifs', 'Au cours des repas'],
            ['Amlodipine', 'Hypertension', '5mg', 'Pfizer', 1700, 70, true, 'Hypertension', 'Traitement de l\'hypertension', 'Œdèmes', '1 prise par jour'],
            ['Oméprazole', 'Digestion', '20mg', 'AstraZeneca', 1600, 110, false, 'Reflux', 'Anti-acide pour l\'estomac', 'Maux de tête', 'Le matin à jeun'],
            ['Solution de réhydratation orale', 'Digestion', null, 'OMS', 500, 300, false, 'Diarrhée', 'Réhydratation en cas de diarrhée', 'Aucun', 'Diluer dans 1L d\'eau potable'],
            ['Savon antiseptique', 'Soins & Hygiène', null, 'Dettol', 900, 200, false, null, 'Hygiène et désinfection', 'Aucun', 'Usage externe'],
            ['Gel hydroalcoolique', 'Soins & Hygiène', '500ml', 'Local', 1500, 180, false, null, 'Désinfection des mains', 'Sécheresse cutanée', 'Appliquer sur mains propres'],
        ];
        foreach ($medicaments as $m) {
            Medicament::create([
                'nom' => $m[0],
                'categorie_id' => $catModels[$m[1]]->id,
                'pharmacie_id' => $pharmacieModels->random()->id,
                'dosage' => $m[2],
                'laboratoire' => $m[3],
                'prix' => $m[4],
                'stock' => $m[5],
                'ordonnance_obligatoire' => $m[6],
                'maladie' => $m[7],
                'description' => $m[8],
                'effets_secondaires' => $m[9],
                'conseils_utilisation' => $m[10],
                'date_expiration' => now()->addYears(2),
            ]);
        }

        // ---------- Administrateur ----------
        User::create([
            'name' => 'Sangare',
            'prenom' => 'Admin',
            'email' => 'admin@furaso.ml',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'telephone' => '+223 00 00 00 01',
            'ville' => 'Bamako',
            'region' => 'Bamako',
        ]);

        // ---------- Pharmacien ----------
        $pharmacienUser = User::create([
            'name' => 'Diarra',
            'prenom' => 'Awa',
            'email' => 'pharmacien@furaso.ml',
            'password' => Hash::make('password'),
            'role' => 'pharmacien',
            'telephone' => '+223 00 00 00 02',
            'ville' => 'Bamako',
            'region' => 'Bamako',
        ]);
        Pharmacien::create([
            'user_id' => $pharmacienUser->id,
            'pharmacie_id' => $pharmaciePrincipale->id,
            'numero_ordre' => 'PH-2026-001',
            'specialite' => 'Officine',
        ]);

        // ---------- Patient ----------
        $patientUser = User::create([
            'name' => 'Touré',
            'prenom' => 'Moussa',
            'email' => 'patient@furaso.ml',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'telephone' => '+223 00 00 00 03',
            'sexe' => 'M',
            'date_naissance' => '1995-05-20',
            'adresse' => 'Rue 100',
            'quartier' => 'Badalabougou',
            'ville' => 'Bamako',
            'region' => 'Bamako',
            'personne_urgence' => 'Fatoumata Touré',
            'telephone_urgence' => '+223 00 00 00 04',
        ]);
        Patient::create([
            'user_id' => $patientUser->id,
            'date_naissance' => '1995-05-20',
            'sexe' => 'M',
            'groupe_sanguin' => 'O+',
            'personne_urgence' => 'Fatoumata Touré',
            'telephone_urgence' => '+223 00 00 00 04',
        ]);
    }
}
