flowchart TD
    A[Utilisateur] -->|Consulte le site Omeka| B[Omeka - Archive Bien-Être AI]
    B -->|Contenu: articles, infographies, audio| C[Catégories: Stress, Sommeil, Pleine conscience, Outils]
    C --> D[Python - Scripts IA]
    D -->|Résumé, mots-clés, conseils| B
    A -->|Pose une question| E[Interface Q&R]
    E --> D
    D --> E
    style A fill:#f9f,stroke:#333,stroke-width:2px
    style B fill:#bbf,stroke:#333,stroke-width:2px
    style C fill:#bfb,stroke:#333,stroke-width:2px
    style D fill:#fbf,stroke:#333,stroke-width:2px
    style E fill:#ffb,stroke:#333,stroke-width:2px
