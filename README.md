# Forum ![Build Status](https://travis-ci.org/mustorze/forum-laracast.svg?branch=master)
How to create a forum with laravel - Laracast edition

## Installation

### Prerequisites
* To run this project, you must have NPM, Docker and docker-compose installed.

### Step 1
* Clone the project
* By folder root run 'docker-compose up -d' to set up all services!

```bash
git clone git@github.com:mustorze/forum-laracast.git
cd forum-laracast && docker-compose exec php composer install && npm install
cp .env.example .env
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan migrate
npm run dev
```

### Step 2
Need to configure the Algolia and Recaptcha keys, its inside the '.env' file.
```
Get on `https://www.google.com/recaptcha/admin`
RECAPTCHA_SECRET=

Get on `https://www.algolia.com/`
ALGOLIA_APP_ID=
ALGOLIA_KEY=
ALGOLIA_SECRET=
```
