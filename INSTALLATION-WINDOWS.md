# Furaso — Installation sur Windows (WAMP)

Plateforme de pharmacie en ligne (Laravel + Blade). Ce guide fait tourner le projet
sur **WAMP** avec **MySQL**.

> Le dossier `vendor/` est **inclus** dans ce dépôt : tu n'as PAS besoin de Composer.

## 1. Cloner le projet
Ouvre un terminal et place-toi dans le dossier web de WAMP :
```bash
cd C:\wamp64\www
git clone https://github.com/AminataSangare03/furaso.git fso
cd fso
```
Tu auras le projet dans `C:\wamp64\www\fso`.

## 2. Démarrer WAMP
Lance WAMP (icône verte). MySQL doit tourner.

## 3. Créer la base de données
Ouvre **phpMyAdmin** (http://localhost/phpmyadmin, user `root`, mot de passe vide)
et crée une base nommée :
```
furaso
```
(Interclassement conseillé : `utf8mb4_unicode_ci`.)

## 4. Configurer l'environnement
```bash
copy .env.example .env
php artisan key:generate
```
Le `.env.example` est déjà réglé pour MySQL WAMP (host 127.0.0.1, port 3306, user `root`,
mot de passe vide). Si ton MySQL a un mot de passe, mets-le dans `DB_PASSWORD` du `.env`.

> Si `php` n'est pas reconnu, utilise le PHP de WAMP, par ex. :
> `C:\wamp64\bin\php\php8.3.x\php.exe artisan key:generate`

## 5. Créer les tables + données de démo
```bash
php artisan migrate:fresh --seed
```

## 6. Lancer le serveur
```bash
php artisan serve
```
Ouvre : **http://localhost:8000**

## Comptes de démonstration (mot de passe : `password`)
| Rôle | Email |
|------|-------|
| Administrateur | admin@furaso.ml |
| Pharmacien | pharmacien@furaso.ml |
| Patient | patient@furaso.ml |

## Dépannage
- **« could not find driver »** : active `pdo_mysql` dans le `php.ini` de WAMP
  (clic gauche icône WAMP → PHP → Extensions → `pdo_mysql`).
- **APP_KEY manquante** : `php artisan key:generate`.
- **Erreur de connexion DB** : vérifie que la base `furaso` existe et que `DB_*` dans `.env`
  correspond à ton MySQL.

## SQL Server au lieu de MySQL (optionnel)
Dans `.env`, commente le bloc MySQL et décommente le bloc SQL Server, installe le pilote
`sqlsrv`/`pdo_sqlsrv` pour ta version de PHP, crée la base `furaso` sur SQL Server, puis
relance `php artisan migrate:fresh --seed`.
