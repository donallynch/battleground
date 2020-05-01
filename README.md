# Battleground Project for DIGIT

A Laravel 6.4 quick start template.

## Purpose

Technical test

### Routes:

/* Landing page */
1. /
2. /create-player
3. /submit-battle
4. /leaderboard
5. /battles

### Controllers:

BattlesController
CreatePlayerController
IndexController
LeaderboardController
SubmitBattleController

### MySQL Database: battleground:

battles
migrations
users

## Installation

1. Clone the project: git clone
2. cd <project-root-directory> (the folder containing the /app/ directory)
3. Clone laradock: git clone https://github.com/Laradock/laradock.git
4. Follow overview/instructions here: https://laradock.io/
5. Spin up the project containers: docker-compose up -d nginx mysql phpmyadmin redis workspace
6. Ensure there is a .env file in root directory
7. Run the project in your browser: http://localhost/login
8. composer update
9. php artisan migrate

## INSTRUCTIONS

1. http://localhost/battles
2. mysql> update battles set is_complete = 0;
3. Repeat

## Contributors

Donal Lynch <donal.lynch.msc@gmail.com>

## License

© 2020 Donal Lynch Software, Inc.
