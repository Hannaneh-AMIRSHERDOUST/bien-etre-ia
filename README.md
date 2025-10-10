# Projet Bien-Être AI

## Description du projet
Bien-Être AI est un **portail numérique de ressources en santé mentale**, enrichi par des résumés et mots-clés générés par l’IA.  
Le projet permet aux utilisateurs de :  

- Consulter des ressources fiables sur le stress, le sommeil, la pleine conscience et d’autres outils de bien-être  
- Obtenir des **résumés et mots-clés générés automatiquement** par un LLM  
- Poser des questions à une **interface Q&R interactive** pour obtenir des conseils éducatifs  

Chaque ressource contient les informations suivantes :  

- **Titre**  
- **Auteur / Source**  
- **Date**  
- **Description courte**  
- **Type** (Article, Infographie, Audio, Checklist)  
- **Catégorie** (Stress, Sommeil, Pleine conscience, Outils)  
- **Tags / Mots-clés**  
- **URL ou fichier**  

Les données sont stockées dans **Omeka Classic**, puis enrichies par des **scripts Python** pour générer résumés, tags et suggestions interactives.

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
