<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation\Exclude;
/**
 * @MongoDB\Document
 */
class Score
{
    /**
    * @MongoDB\Id
    */
    private ?string $id = null;
    /**
     * @MongoDB\EmbedOne(targetDocument=User::class)
     */
    private User $user;
    /**
     * @MongoDB\Field(type="string")
     * @Exclude()
     */
    private ?string $externalId = null;
    /**
     * @MongoDB\Field(type="integer")
     */
    private ?int $score = 0;
    /**
     * @MongoDB\Field(type="date")
     */
    private $finishedAt = null;

    /**
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * @param string|null $externalId
     */
    public function setExternalId(?string $externalId): void
    {
        $this->externalId = $externalId;
    }

    /**
     * @return \DateTime
     */
    public function getFinishedAt(): \DateTime
    {
        return $this->finishedAt;
    }

    /**
     * @param \DateTime $finishedAt
     */
    public function setFinishedAt(?\DateTime $finishedAt): void
    {
        $this->finishedAt = $finishedAt;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}