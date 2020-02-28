<?php
namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Game
{
    public function __construct()
    {
        $this->scores = new ArrayCollection();
    }

    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;
    /**
     * @MongoDB\Field(type="integer")
     */
    protected ?int $gameId = null;
    /**
     * @MongoDB\EmbedMany(targetDocument=Score::class)
     */
    protected $scores;
    /**
     * @MongoDB\Field(type="bool")
     */
    protected ?bool $completed = null;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getGameId(): int
    {
        return $this->gameId;
    }

    /**
     * @param int $gameId
     */
    public function setGameId(int $gameId): void
    {
        $this->gameId = $gameId;
    }

    /**
     * @return mixed
     */
    public function getScores()
    {
        return $this->scores;
    }

    public function setScores(ArrayCollection $scores)
    {
        $this->scores = $scores;
    }

    /**
     * @param Score $score
     */
    public function addScore(Score $score): void
    {
        $this->scores[] = $score;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        /** @var Score $score */
        foreach ($this->scores as $score) {
            if(!$score->getFinishedAt()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param bool $completed
     */
    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }


}