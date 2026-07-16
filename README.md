# Plateforme de Gestion de Centre de Formation dans un Pays

## Contexte
Une plateforme en ligne pour qui a pour but :
* Centraliser les centres de formation professionnelle d'un pays sur une seule plateforme.
* Regrouper l'ensemble des apprenants déjà existants, avec un profil unique par personne.
* Rendre chaque formation certifiante : un certificat numérique disponible en ligne pour tous les centres, et vérifiable publiquement.
* À terme, organiser des tests standardisés pour tous les apprenants, dans des salles dédiées, à la manière d'un examen national voire international.

## Technologies

 1. Backend

    - **API :** Laravel 12
    - **Authentification :** Laravel Sanctum
    - **ORM :** Eloquent

        > On a opte pour Laravel grace a son ecosysteme tres vaste. Laravel nous offre deja plusieurs outils pret a utiliser comme ce systeme d'Authentification ***Laravel Sanctum*** et d'ORM ***Eloquent***

 2. Base des Donnees

    - **SGBD :** SQLite (Developpement) | PostgreSQL (Production)

        > Pour faciliter le developpement, on utilise SQLite comme SGBD mais au final se sera PostgreSQL. Vu que les 2 SGBD sont basees sur SQL et qu'on utilise l'ORM Eloquent de Laravel, la migration de SQLite vers PostgreSQL ne sera pas difficile.
        
 3. Frontent

## Modelisation des Donnees
 
   [Representation graphique simplifiee de la structure des donnees](https://drawsql.app/teams/jeanbrillant/diagrams/plateforme-formation)

   **Petite Explications :**
   - Dans la table Role, type peut avoir les valeurs suivantes : Apprenant, Formateur, Admin, Super-Admin
   - Dans la table Centre, statut peut avoir les valeurs suivantes : En_attente, Valide, Rejete 

## Regles des Gestions

   - Un utilisateur a un compte
   - La plateforme a un Super-Utilisateur
   - Un utilisateur peut avoir plusieurs roles : Admin (Admin d'un Centre de Formation), Apprenant, Formateur
   - Un utilisateur peut creer un ou plusieurs Centre de Formation
   - Le Super-Utilisateur peut valider ou non la creation d'un nouvel Centre de Formation
   - Lors de la validation de la creation d'un nouvel Centre de Formation, l'utilisateur qui a demande sa creation devient automatiquement son Admin
   - L'Admin d'un Centre de Formation peut ajouter d'autre utilisateur comme Admin
   - Les Admins cree les formations dans un Centre de Formation
   - Une formation est liee a un seul Centre de Formation
   - Chaque utilisateur peut s'inscrire a une ou plussieurs formations
   - Un Admin peut assigner un ou plusieurs Formateur a une formation


## Installation

\`\`\`bash
git clone git@github.com:JeanBrillant/PlateformeFormation.git
cd plateforme-formation
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
\`\`\`

L'API est accessible sur `http://127.0.0.1:8000/api`.

Un compte Super-Admin est créé automatiquement via le seeder :
- Téléphone : `0341111110`
- Mot de passe : `123456`


## Routes de l'API

| Méthode | Route | Auth requise | Description |
|---|---|---|---|
| POST | /api/register | Non | Créer un compte (avec choix des rôles apprenant/formateur) |
| POST | /api/login | Non | Connexion, retourne un token Sanctum |
| POST | /api/centres | Oui | Soumettre une demande de création de centre |
| PATCH | /api/centres/{centre}/valider | Oui (Super-Admin) | Valider un centre, l'admin devient automatique |
| POST | /api/formations | Oui (Admin du centre) | Créer une formation |
| GET | /api/formations | Oui | Lister les formations |


## Hypothèses prises sur les zones ambiguës

- Un utilisateur peut créer/demander plusieurs Centres de Formation (le pays a des besoins différents par région).
- Un Centre peut avoir plusieurs Admins (répartir la charge de gestion des formations et formateurs).
- Le Super-Admin est créé uniquement via un seeder, jamais via l'inscription publique (sécurité).
- Un formateur est rattaché directement à une formation (table `formation_formateur`), pas à un centre — il peut donc intervenir dans plusieurs centres différents.
- Un Admin est rattaché à un centre précis via la table `role` (`centre_id`), un même compte peut avoir plusieurs lignes admin pour plusieurs centres.
- Une formation est toujours liée à un seul centre, dès sa création (même si aucun formateur n'est encore assigné).
- Une formation hérite implicitement de la localisation de son centre (pas de lieu distinct par formation).


## Usage de l'IA

J'ai utilisé Claude pour :
- Discuter et challenger mes choix de modélisation (notamment le cumul de rôles sans héritage, et le rattachement des formateurs/admins).
- Générer des squelettes de migrations, contrôleurs et resources Laravel, que j'ai ensuite adaptés et débuggés moi-même.
- Comprendre et corriger des erreurs (validation Laravel, Sanctum, contraintes SQL).

Je n'ai pas laissé l'IA décider seule des règles métier : chaque hypothèse (multi-centres, multi-admins, séparation formateur/centre) est une décision que j'ai prise et justifiée moi-même après discussion.


## Limites Connues

- Une formation hérite implicitement de la localisation de son centre, pas de lieu distinct géré pour l'instant.
- Le rejet et la resoumission d'un Centre de Formation ne sont pas encore implémentés.
- Les inscriptions et la génération de certificats (route `/verify/{id}`) sont en cours d'implémentation.
- Le mécanisme de parrainage (bonus) n'a pas été traité, faute de temps.
- Pas d'interface graphique (frontend) pour le moment — l'API a été priorisée.
- Pas de tests automatisés (unitaires/fonctionnels), faute de temps.