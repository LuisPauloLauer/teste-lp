<?php

namespace App\Entity;

use App\Repository\HashesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HashesRepository::class)
 */
class Hashes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $batch;

    /**
     * @ORM\Column(type="integer")
     */
    private $n_bloco;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $input_string;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $key;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @ORM\Column(type="integer")
     */
    private $n_attempts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBatch(): ?\DateTimeInterface
    {
        return $this->batch;
    }

    public function setBatch(\DateTimeInterface $batch): self
    {
        $this->batch = $batch;

        return $this;
    }

    public function getNBloco(): ?int
    {
        return $this->n_bloco;
    }

    public function setNBloco(int $n_bloco): self
    {
        $this->n_bloco = $n_bloco;

        return $this;
    }

    public function getInputString(): ?string
    {
        return $this->input_string;
    }

    public function setInputString(string $input_string): self
    {
        $this->input_string = $input_string;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getNAttempts(): ?int
    {
        return $this->n_attempts;
    }

    public function setNAttempts(int $n_attempts): self
    {
        $this->n_attempts = $n_attempts;

        return $this;
    }
}
