# Bien-Être IA - Documentation

## Problème rencontré

L'API Omeka S bloque la création d'items via les clés API, même pour les utilisateurs global_admin. 
C'est une limitation connue d'Omeka S.

## Solution finale

Utilisez l'interface admin d'Omeka S pour créer les exercices manuellement, ou utilisez le module CSV Import intégré d'Omeka S.

## Fichiers créés

- `apiOmk.html` - Interface de création d'exercice (ne fonctionne pas à cause des permissions API)
- `bulk-import.html` - Import CSV (ne fonctionne pas à cause des permissions API)
- `omeka-proxy.php` - Proxy PHP pour contourner CORS

## Clés API configurées

- Identity: `9x53ZNIuZMJofzCo54y7yRUVHbx1bnUw`
- Credential: `Pnf97t9lJ28ypl8DC575a0pw8ayhjPef`
- Propriétaire: ha.sheardoost@gmail.com (global_admin)

## Alternative recommandée

Utilisez le module CSV Import d'Omeka S:
1. Connectez-vous à l'admin Omeka
2. Allez dans Modules → CSV Import
3. Importez le fichier `assets/exercises.csv`
4. Mappez les colonnes aux propriétés beo:
