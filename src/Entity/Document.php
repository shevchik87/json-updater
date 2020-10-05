<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 * @ORM\Table(name="documents")
 */
class Document implements \JsonSerializable
{
    const STATUS_DRAFT = 'draft';

    const STATUS_PUBLISHED = 'published';

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $payload;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $modifyAt;

    /**
     * @ORM\Column(type="integer", name="user_id")
     * @var int
     */
    private $userId;

    public function isPublished()
    {
        return $this->status == self::STATUS_PUBLISHED;
    }
    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function setPayload($payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifyAt(): ?\DateTimeInterface
    {
        return $this->modifyAt;
    }

    public function setModifyAt(?\DateTimeInterface $modifyAt): self
    {
        $this->modifyAt = $modifyAt;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'payload' => $this->payload,
            'createAt' => $this->createdAt->format("Y-m-d H:i:sO"),
            'modifyAt' => $this->modifyAt->format("Y-m-d H:i:sO")
        ];
    }

}
