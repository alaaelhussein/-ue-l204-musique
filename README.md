# UE L204 – Web dynamique et bases de données  
Gestion d’albums musicaux (Mini-projets)  


## Auteurs
- Guillaume Andrieu
- Baptiste Saint-Pierre
---
- Anistratenco Serguei
- El Hussein Alaa
- Ferrand Maxime
- Shakurov Matin

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
