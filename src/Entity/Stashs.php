<?php

namespace App\Entity;

use App\Repository\StashsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: StashsRepository::class)]
#[UniqueEntity(fields: "alias")]
#[UniqueEntity(fields: "address")]
class Stashs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    private $alias;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    private $address;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    #[Assert\Type("string")]
    private $type;

    #[ORM\ManyToOne(targetEntity: Countries::class, inversedBy: 'stashs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private $country;

    #[ORM\ManyToMany(targetEntity: Missions::class, inversedBy: 'stashs')]
    private $missions;

    #[ORM\OneToMany(mappedBy: 'stash', targetEntity: Missions::class)]
    private $mission;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
        $this->mission = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCountry(): ?countries
    {
        return $this->country;
    }

    public function setCountry(?countries $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Missions[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Missions $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
        }

        return $this;
    }

    public function removeMission(Missions $mission): self
    {
        $this->missions->removeElement($mission);

        return $this;
    }

    /**
     * @return Collection|Missions[]
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }
}
