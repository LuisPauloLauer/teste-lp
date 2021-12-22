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
    private $dbatch;

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
    private $skey;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shash;

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
        return $this->dbatch;
    }

    public function setBatch(\DateTimeInterface $dbatch): self
    {
        $this->dbatch = $dbatch;

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
        return $this->skey;
    }

    public function setKey(string $skey): self
    {
        $this->skey = $skey;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->shash;
    }

    public function setHash(string $shash): self
    {
        $this->shash = $shash;

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
