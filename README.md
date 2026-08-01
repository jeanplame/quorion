# QUORION - site dynamique

Le site public reprend les feuilles de style, scripts, animations, images et mise en page du template **SEO Master** placé dans `SeoMaster/`. Les contenus QUORION sont alimentés par MySQL et administrables depuis le navigateur.

## Installation locale (Wamp)

1. Démarrer les services Apache et MySQL dans Wamp.
2. Importer `database/quorion.sql` dans phpMyAdmin, ou exécuter ce fichier avec MySQL. Il crée la base `quorion` et ses données initiales.
3. Ouvrir `http://localhost/quorion/`.

La connexion MySQL est déjà configurée dans `app/config.php` avec `localhost`, `root` et un mot de passe vide, comme demandé.

## Administration

Ouvrir `http://localhost/quorion/admin/login.php`.

- E-mail : `admin@quorion.local`
- Mot de passe initial : `Quorion2026!`

Changez ce mot de passe avant toute mise en ligne. L’administration permet de modifier les paramètres et textes, les valeurs, les services, les projets, les messages de contact et les abonnés à la newsletter.

## Arborescence utile

- `app/` : connexion MySQL et fonctions communes.
- `database/quorion.sql` : schéma + données initiales.
- `partials/` : en-tête et pied de page dynamiques utilisant le design SEO Master.
- `admin/` : espace d’administration protégé.
- `SeoMaster/` : fichiers d’origine du template, préservés.
