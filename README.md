# Projet Bien-Être AI

## Description du projet
Bien-Être AI est un **portail numérique de ressources en santé mentale**, enrichi par des résumés et mots-clés générés par l’IA.  
Le projet permet aux utilisateurs de :  

- Consulter des ressources fiables sur le stress, le sommeil, la pleine conscience et d’autres outils de bien-être  
- Obtenir des **résumés et mots-clés générés automatiquement** par un LLM  
- Poser des questions à une **interface Q&R interactive**  

Chaque ressource contient :  

- **Titre**  
- **Auteur / Source**  
- **Date**  
- **Description courte**  
- **Type** (Article, Infographie, Audio, Checklist)  
- **Catégorie** (Stress, Sommeil, Pleine conscience, Outils)  
- **Tags / Mots-clés**  
- **URL ou fichier**  

Les données sont stockées dans **Omeka Classic** et enrichies via des **scripts Python** pour générer résumés et mots-clés.

---

## Diagramme Entité-Relation
Pour que GitHub affiche correctement le diagramme, utilisez une **image exportée depuis Mermaid Live Editor** :  

![Diagramme ER](https://raw.githubusercontent.com/ton-compte/ton-repo/main/diagramme-er.png)

> Remarque : le diagramme Mermaid ne se rend pas nativement dans GitHub README.md. Exportez-le en PNG/SVG pour l’afficher.

---

## Prompt ChatGPT utilisé
```text
Tu es un assistant expert en santé mentale et bien-être.
Pour chaque ressource fournie (article, audio, infographie, checklist), tu dois :

1. Résumer le contenu en 3-4 phrases maximum
2. Générer 5 mots-clés pertinents
3. Fournir un conseil pratique ou insight basé sur le contenu

Format de sortie :
- Résumé : [texte]
- Tags : [mot1, mot2, mot3, mot4, mot5]
- Conseil : [texte]
