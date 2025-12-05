# Rapport intermédiaire – UE L204 – Web dynamique et bases de données  
Projet : Gestion d’albums musicaux (Mini-projets)  
12/05/2025

## Auteurs
- Guillaume Andrieu
- Baptiste Saint-Pierre
- (equipe pedagogique)
- 
- Anistratenco Serguei
- El Hussein Alaa
- Ferrand Maxime
- Shakurov Matin

---

## Méthode de travail

Première réunion d'équipe le mardi 02/12/2025.  
Nous avons choisi de garder le rythme léger sur les réunions : une seule en présentiel, le reste de la coordination se fait en asynchrone sur Discord et GitHub.  
Ce fonctionnement permet à chacun d'avancer à son rythme, de rester joignable, et de garder de la visibilité sur l’avancement global sans multiplier les réunions inutiles.

**Outils utilisés :**
- **GitHub** – Versioning, stockage du code, suivi des tâches  
  [https://github.com/alaaelhussein/-ue-l204-musique](https://github.com/alaaelhussein/-ue-l204-musique)  
  Convention de commit : messages explicites et descriptifs, chacun pousse ses modifications régulièrement.
- **Discord** – Conversations, organisation quotidienne, partage d’écran  
  Utile pour régler rapidement les blocages et coordonner le groupe à distance.

---

## Objectifs du projet

- Authentification sécurisée (password hash/BCRYPT)
- Gestion des rôles (admin/utilisateur classique)
- Consultation de la liste d’albums, accès protégé selon le rôle
- Interface simple, conviviale et intuitive
- Utilisation sécurisée de la base de données (PDO, requêtes préparées)

### Choix techniques
- Mot de passe hashés avec `password_hash()`
- Sécurité des requêtes SQL via PDO et requêtes préparées
- Contrôle d'accès par rôles, stockés en BDD

### Parcours utilisateur prévu
1. Accès à la page d'accueil
2. Authentification par formulaire
3. Création de session sécurisée si validation réussie
4. Redirection vers le dashboard adapté au rôle
5. Admin : gestion CRUD des albums / Utilisateur : simple consultation
6. Déconnexion via bouton dédié

---

## Vision du design – Maquettes principales

- **Login** : Formulaire centré (identifiant + mot de passe), bouton connexion
- **Tableau de bord utilisateur** : Liste albums, barre de recherche, navigation claire, déconnexion accessible
- **Page admin** : Boutons Ajouter/Modifier/Supprimer album, statistiques, gestion utilisateurs optionnelle, accès aux paramètres

---

## Avancement du projet

### Réalisé

- **Base de données**  
  Fichier `musique.sql` complet et fonctionnel.
- **Authentification**  
  Formulaire d’identification opérationnel, gestion des sessions, redirection fidèle au rôle.
  Déconnexion via `logout.php`.
- **Affichage de la liste d’albums**  
  Requête PDO, affichage dynamique, extraction des données correcte.
- **Structure PHP**  
  Centralisation dans `config.php`, gestion basique des erreurs PDO, usage cohérent des variables globales, requêtes préparées partout.

### À finaliser / En cours

- Vérification de session sur toutes les pages protégées (via `session_start()` et fichier commun d’auth).
- Redirections automatiques si session absente ou expirée.
- Ajout de messages d’erreur/succès dans `$_SESSION`.
- Vérification stricte du rôle sur les pages et fonctionnalités sensibles.
- Masquage des options admin pour les utilisateurs simples.
- Protection contre l’accès direct aux pages admin.
- Terminer l’implémentation CRUD (ajout/modif/suppression) d’albums.
- Mise en place de la recherche/filtrage albums.
- Intégration de `header.php`/`footer.php`, peaufinage du CSS pour responsive et clarté.
- Redirections intelligentes dans `index.php` selon connexion/rôle.
- Harmonisation UX (messages, couleurs, organisation).
- Vérification et tests complets (flux, erreurs, droits d’accès).

---

## Tests à faire avant rendu

- Connexion/déconnexion pour tous types de comptes
- Blocage des pages admin pour les users simples
- Fonctions d’ajout, modification, suppression d’albums
- Recherche sur tous les critères (avec valeurs bizarres/vides)
- Absence d'accès aux pages sensibles sans session

---

## Difficultés rencontrées

**Problèmes déjà résolus :**
- Push GitHub refusé → correction de l’URL du dépôt
- Fichier SQL mal formaté → réparation pour usage dans phpMyAdmin
- Hash des mots de passe incompatible → correction du format attendu par BCRYPT
- Paramètres de connexion PDO incorrects → ajustement du fichier `config.php`

**Points encore à régler :**
- Vérification de session incomplète sur toutes les pages
- Pages brutes sans CSS ni responsive, interface à améliorer
- Affichage centralisé des messages d'erreurs/succès
- Redirections post-login à améliorer selon chaque rôle
- CRUD sur les albums pas terminé/testé

---

## Conclusion intermédiaire

Après cette première semaine, le projet dispose d’une base solide : la BDD fonctionne, l’authentification est opérationnelle, l’architecture PHP tient la route.  
L’équipe maîtrise désormais les outils (GitHub, phpMyAdmin), le dépôt partagé tourne bien et le mode de communication est efficace.  
La première phase a aussi permis de valider les grandes lignes de design et d’interface à partir des maquettes proposées.  
La prochaine étape visera : sécurisation complète (sessions, rôles), finalisation des fonctions admin (CRUD), et amélioration de l’UX (CSS, ergonomie).  
Des tests approfondis et une documentation rigoureuse permettront de présenter in fine un site stable et conforme aux attentes de l’UE L204.

---
