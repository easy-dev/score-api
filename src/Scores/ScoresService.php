<?php

namespace App\Scores;

use App\Document\Game;
use App\Document\GamePersistance;
use Doctrine\ODM\MongoDB\DocumentManager;

class ScoresService
{
    /**
     * @var ScoreProviderInterface
     */
    private ScoreProviderInterface $scoreProvider;
    /**
     * @var DocumentManager
     */
    private DocumentManager $dm;
    /**
     * @var GamePersistance
     */
    private GamePersistance $gamePersistance;

    public function __construct(
        ScoreProviderInterface $scoreProvider,
        DocumentManager $dm,
        GamePersistance $gamePersistance
    ) {
        $this->scoreProvider = $scoreProvider;
        $this->dm = $dm;
        $this->gamePersistance = $gamePersistance;
    }

    public function getGameResults(int $gameId, Sorting $sorting): Game
    {
        /** @var Game $game */
        $game = $this->dm->getRepository(Game::class)->findOneBy(['gameId' => $gameId]);

        if (!$game || !$game->isCompleted()) {
            $externalGames = $this->scoreProvider->getGameResults($gameId);
            $game = $this->gamePersistance->persistGames($gameId, $externalGames);
        }

        if ($sorting->getField() && $sorting->getOrder()) {
            $game->setScores($sorting->sort($game->getScores()->getValues()));
        }

        return $game;
    }
}