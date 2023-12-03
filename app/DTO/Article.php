<?php

namespace App\DTO;

use Carbon\Carbon;

class Article
{
    public function __construct(
        protected string $title,
        protected string $description,
        protected string $content,
        protected string $url,
        protected Carbon $publishedAt,
        protected ?string $author = null,
        protected ?string $coverUrl = null,
        protected ?string $source = null,
        protected ?string $provider = null,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getPublishedAt(): Carbon
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(Carbon $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getCoverUrl(): ?string
    {
        return $this->coverUrl;
    }

    public function setCoverUrl(?string $coverUrl): void
    {
        $this->coverUrl = $coverUrl;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(?string $provider): void
    {
        $this->provider = $provider;
    }
}
