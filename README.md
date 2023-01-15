<h1 align="center">PHP MVC Framework</h1>

<p align="center">Basic of MVC's concept.</p>

### Noting, the only purpose of this framework is pure educational to give you all some knowledges. It's not recommended to use this framework on any of your production websites.

<p>The core package: <a target="_blank" href="https://github.com/alfianchii/alfianchii-php-mvc-core">here</a></p>

---

## Usage

Download the latest release of core package from the [core releases page](https://github.com/alfianchii/alfianchii-php-mvc-core/releases "Core release package"). Open the `core` folder and explore the source code.

### Installation

- Clone the repository `git clone https://github.com/alfianchii/php-mvc-framework`
- Create database scheme
- In the root folder, create `.env` which is based from `.env.example` file and adjust database parameters (including scheme name)
- Install packages using Composer. For example run `composer install`
- From the project root directory, migrate the migrations by executing `php migrations.php`
- Go to `public` folder
- Run server with `php -S localhost:8080` command and open `http://localhost:8080` in your favourite browser
