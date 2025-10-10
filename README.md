# Projet Bien-Être AI

## Description du projet
Notre projet consiste à développer un **portail numérique de ressources en santé mentale**.  
Chaque ressource contient les informations suivantes, organisées dans Omeka :  

- **Titre**  
- **Auteur / Source**  
- **Date**  
- **Description**  
- **Type** (Article, Infographie, Audio, Checklist)  
- **Catégorie** (Stress, Sommeil, Pleine conscience, Outils de gestion)  
- **Tags / Mots-clés**  
- **URL / Fichier**  

L'utilisateur peut **consulter les ressources via le site Omeka** et **poser des questions à l’IA**.  
Les données sont stockées dans **Omeka Classic** et enrichies via des **scripts Python** pour générer résumés et mots-clés.

---

## Diagramme Entité-Relation
```mermaid
erDiagram
    RESSOURCE {
        int id
        string titre
        string auteur
        string date
        string description
        string type
        string categorie
        string tags
        string url
    }
    UTILISATEUR {
        int id
        string nom
        string email
    }
    RESSOURCE ||--o{ UTILISATEUR : "consulte"
