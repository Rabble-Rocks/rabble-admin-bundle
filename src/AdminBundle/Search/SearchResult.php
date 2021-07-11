<?php

namespace Rabble\AdminBundle\Search;

class SearchResult
{
    private string $title;

    private string $type;

    private string $uri;

    private float $score;

    private ?string $template;

    private array $extras = [];

    public function __construct(
        string $title,
        string $type,
        string $uri,
        float $score,
        ?string $template = null
    ) {
        $this->title = $title;
        $this->type = $type;
        $this->uri = $uri;
        $this->score = $score;
        $this->template = $template;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function setScore(float $score): void
    {
        $this->score = $score;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): void
    {
        $this->template = $template;
    }

    public function getExtras(): array
    {
        return $this->extras;
    }

    public function setExtras(array $extras): void
    {
        $this->extras = $extras;
    }

    /**
     * @param mixed $value
     */
    public function addExtra(string $name, $value): void
    {
        $this->extras[$name] = $value;
    }

    /**
     * @param null|mixed $default
     *
     * @return mixed
     */
    public function getExtra(string $name, $default = null)
    {
        return $this->extras[$name] ?? $default;
    }
}
