# Bien-Être IA

Projet de gestion d'exercices de bien-être avec Omeka S et intégration IA.

## Contenu

- **Vocabulaire personnalisé** : `assets/vocab.ttl` (namespace beo:)
- **Données** : `assets/exercises.csv` (exemples d'exercices)
- **Interface API** : `apiOmk.html` (création et gestion d'exercices)
- **Import CSV** : `bulk-import.html` (import en masse)
- **Module Omeka S** : `modules/BienEtreBot/` (chatbot avec IA)

## Installation

1. Copier le module dans votre installation Omeka S
2. Activer le module dans l'administration Omeka S
3. Accéder au chatbot : `/bien-etre-bot`

## Technologies

- Omeka S
- Ollama (IA locale)
- D3.js
- PHP/Laminas
