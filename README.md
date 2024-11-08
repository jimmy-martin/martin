# Symfony Docker

## Lancer le projet

1. Si ce n'est pas déjà fait, [installez Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Exécutez `make start` afin de lancer le projet
3. Exécutez `make sf c='doctrine:fixtures:load'` afin de charger les données de test (elles devraient être générées automatiquement, c'est juste pour être sûr)
4. Ouvrez `http://localhost:8080/api` pour afficher la documentation de l'API
5. Exécutez `docker compose down --remove-orphans` pour arrêter les conteneurs Docker.

> Les commandes sont à effectuer à la racine du projet.  

> Quelques commandes sont disponibles dans le Makefile, si besoin.

**Enjoy!**

## Détails

Le MCD et le sql se trouvent dans le dossier `docs/project` 

- Deux variables d'env `MAX_CREATED_USERS` et `MAX_CREATED_PARTIES` 
sont disponibles pour gérer la quantité de données à générer lors de l'exécution des fixtures.
- Je n'ai pas eu le temps d'implémenter les partitions,
mais j'ai laissé le SQL comme si je voulais les créer (perte du code quelques temps avant remise du projet)
- J'ai utilisé une librairie pour gérer les mappings DTO/Entity, Entity/DTO.
On peut les voir dans le code en faisant une recherche globale sur `$this->mapper->map` ou
`$this->iterableMapper->mapIterable`.
- Les requêtes optmisées/paginées sont dans le dossier `src/Repository/PartyRepository.php`

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.dev), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
