# 👤 Étudiant 4 – Interface graphique et gestion des utilisateurs (Serghei)

AS: je suis responsable de l’interface (css + gabarits) et de la page admin utilisateurs.

## tâches

AS: j’ai conçu le style global dans [assets/style.css](../assets/style.css) (layout, boutons, cartes, formulaires, tableaux).

AS: j’ai créé la page d’accueil dans [index.php](../index.php) avec une section "hero" + un bloc de fonctionnalités pour présenter le projet.

AS: j’ai mis en place les gabarits communs dans [includes/header.php](../includes/header.php) et [includes/footer.php](../includes/footer.php) pour garder une ui cohérente.

AS: j’ai développé la gestion des utilisateurs dans [pages/gestion_utilisateurs.php](../pages/gestion_utilisateurs.php) :
AS: - création de comptes avec rôle admin/user
AS: - modification du rôle (admin ↔ user)
AS: - suppression de comptes (avec garde-fous: pas de suppression/édition du compte connecté)

AS: j’ai fait un responsive design avec priorité desktop (grilles, cartes, tables, formulaires).

AS: j’ai vérifié la cohérence ui/ux sur toutes les pages (mêmes composants visuels, même structure, mêmes couleurs).

## livrables

AS: style.css → [assets/style.css](../assets/style.css)
AS: index.php → [index.php](../index.php)
AS: header.php/footer.php → [includes/header.php](../includes/header.php) + [includes/footer.php](../includes/footer.php)
AS: gestion_utilisateurs.php → [pages/gestion_utilisateurs.php](../pages/gestion_utilisateurs.php)

## notes (si on me questionne en oral)

AS: le header affiche le statut connecté + rôle, et propose les actions (catalogue, gestion utilisateurs, logout).

AS: la page gestion utilisateurs est admin-only et utilise pdo + requêtes préparées.

AS: toutes les actions post sensibles ont un token csrf (anti suppression "à l’aveugle").
