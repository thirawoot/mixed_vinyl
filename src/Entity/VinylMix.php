<?php

namespace App\Entity;

use App\Repository\VinylMixRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation\Slug;

#[ORM\Entity(repositoryClass: VinylMixRepository::class)]
class VinylMix
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 20)]
    private ?string $genre = null;

    #[ORM\Column]
    private ?int $trackCount = null;
    
    #[ORM\Column]
    private ?int $votes = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Slug(fields: ['title'])]
    private ?string $slug = null;
   
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTrackCount(): ?int
    {
        return $this->trackCount;
    }

    public function setTrackCount(int $trackCount): self
    {
        $this->trackCount = $trackCount;

        return $this;
    }

    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function upVote(): void
    {
        $this->votes++;
    }
    public function downVote(): void
    {
        $this->votes--;
    }

    public function getVotesString(): string
    {
        $prefix = ($this->votes === 0) ? '' : (($this->votes >= 0) ? '+' : '-');
        return sprintf('%s %d', $prefix, abs($this->votes));
    }

    public function getImageUrl(int $width): string
    {
        return sprintf(
            'https://picsum.photos/id/%d/%d',
            ($this->getId() % 1000) + 83, // number between 83 and 1083, based on the id
            $width
        );
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}
