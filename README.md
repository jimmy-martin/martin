# Symfony Docker

## Lancer le projet

1. Si ce n'est pas déjà fait, [installez Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Exécutez `make start` afin de lancer le projet

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up --pull always -d --wait` to set up and start a fresh Symfony project
4. Open `http://localhost:8080` in your favorite web browser
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

**Enjoy!**

## Docs

Documentation/files useful for the project are in `docs/project`

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.dev), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
