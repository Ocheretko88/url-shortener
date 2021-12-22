<p align="center"><img src="https://user-images.githubusercontent.com/89727507/146746215-d3566c91-565d-412b-b944-2d35b038a592.png" width="200"></a></p>

# Simple URL Shortener

## About URL Shortener

URL shortener provides you with a chance to create short and attractive links to any website of the globe. Clone this repository, take the steps listed below and try my URL shortener.

- Clone this repository via GitHub Desktop or copy this command: `git clone git@github.com:Ocheretko88/url-shortener.git`.
- Go to the folder application using `cd url-shortener` command.
- If composer is installed, use this command: `composer install --ignore-platform-reqs`. If you use Docker, run: 
    `docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs`
- Copy `.env.example` file to `.env` on the root folder. For example, you can use `cp .env.example .env` command.
- Run `php artisan key:generate`.
- Run `./vendor/bin/sail build --no-cache`.
- Run `./vendor/bin/sail up -d`.
- Run `./vendor/bin/sail npm install`.
- Run `./vendor/bin/sail artisan migrate --seed`.
- Open your `.env` file and change the database name `DB_DATABASE`, username `DB_USERNAME` and password `DB_PASSWORD`.
- Go to `localhost` and enjoy.

To use GitHub auth service, you need to create your a new application at https://github.com/settings/developers, get you personal client id and your personal client secret key.

URL shortener is as simple as ABC. You paste a long URL, choose a random short key or your custom one and click `Create Short URL` button. That's it.

## Plans to do

Here are a few issues that I plan to add to this project in the nearest future:
- Statistics
- Logs via an ELK stack
- Monitoring via Graphana
- Letsencrypt SSL certificate
- Top visited urls by monthes stats
- Load balancer and two shortener instances (traefic or common nginx instance)
- Tests (unit, integrations)


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
