<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\Uuid;

#[Entity, Table(name: 'wiki')]
final class Wiki
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'string', length: 75, nullable: false)]
    private string $title;

    #[Column(type: 'text', nullable: false)]
    private string $description;

    #[Column(type: 'string', unique: true)]
    private string $url;

    #[Column(type: 'datetime_immutable', nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt;

    #[Column(type: 'datetime_immutable', nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $uniqUrl = sprintf("$url-%s", Uuid::uuid4()->toString());

        $this->url = (new Slugify())->slugify($uniqUrl);
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
