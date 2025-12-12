# UE L204 – Web dynamique et bases de données  
Gestion d’albums musicaux (Mini-projets)  

## Comptes de test (dump SQL)
- Mot de passe commun (admin + users) : `Test1234!`
- Admin : identifiant `Administrateur`
- Users : `Utilisateur1` ... `Utilisateur19`

Le dump fourni dans [assets/BDD_musique.sql](assets/BDD_musique.sql) contient :
- 42 albums
- 20 utilisateurs (pour respecter la contrainte « au moins 20 entrées par table »)

## Sécurité / Consignes
- Connexion via mot de passe chiffré : `password_hash()` / `password_verify()`
- Requêtes PDO : uniquement via `prepare()` / `execute()`
- Protection CSRF : ajout d’un token sur les formulaires POST (suppression, ajout, édition, logout)
- Session : `session_regenerate_id(true)` après login


## Auteurs
- Guillaume Andrieu
- Baptiste Saint-Pierre
---
- Anistratenco Serghei
- El Hussein Alaa
- Ferrand Maxime
- Shakurov Matin

---

