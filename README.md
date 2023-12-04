# Fresh news aggregator

This news aggregator retrieves today's articles from multiple sources and delivers them through an API.
The project is built with Laravel 10.

Articles are updated every 30 minutes by a cron job (or by hand using CLI): new articles are added, existing articles 
are updated and articles that are older than 1 day are deleted.

## Installation

The project is dockerized using Laravel Sail. To build it, you need to have docker and docker-compose installed.

You can seed the database with some fake articles by running `sail artisan db:seed ArticleSeeder`.

## CLI

You can use the CLI to sync articles with the command `sail artisan app:aggregate`.

## Sources

1. NewsAPI (German sources: bild, der-tagesspiegel, die-zeit, focus, gruenderszene,
   handelsblatt, spiegel-online, t3n, wired-de, wirtschafts-woche
2. The Guardian
3. New York Times

## Api endpoints

### Articles

#### Search articles

`GET /api/articles`

##### Parameters

| Name | Type | Description |
| ---- | ---- | ----------- |
| page | int | Page number |
| query | string | Search query |

#### Details of an article

`GET /api/articles/{id}`

##### Parameters

| Name | Type | Description  |
| ---- | ---- |--------------|
| id | string | Article uuid |
