Déploiement
===========

Ce module utilise les noeuds définis dans le module Admin pour échanger des informations avec les machines distantes à travers un agent ou en utilisant les outils du système tel que le ssh pour un mode agentless.


Pré-requis
----------
Modules:
- Core
- User

Configuration
-------------

### Lecture des informations dans la base de données

Contenu de **app/config/parameters.yml**:

    repository_name:     Test SOS-Paris
    repository_dbname:   scheduler
    repository_host:     %database_host%
    repository_port:     %database_port%
    repository_user:     %database_user%
    repository_password: %database_password%
    repository_driver:   %database_driver%

__v1.5.0__