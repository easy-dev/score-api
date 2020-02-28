<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\DocumentManager;

class GamePersistance
{
    /**
     * @var DocumentManager
     */
    private DocumentManager $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function persistGames(int $gameId, array $externalScores): Game
    {
        $document = new Game();
        $document->setGameId($gameId);
        /** @var \App\Scores\External\Score $score */
        foreach ($externalScores as $score) {
            $scoreDocument = new Score();
            $scoreDocument->setExternalId($score->getId());
            $scoreDocument->setScore($score->getScore());
            $scoreDocument->setFinishedAt($score->getFinishedAt());

            $userDocument = new User();
            $userDocument->setExternalId($score->getUser()->getId());
            $userDocument->setName($score->getUser()->getName());
            $scoreDocument->setUser($userDocument);
            $document->addScore($scoreDocument);
        }
        $this->documentManager->persist($document);
        $this->documentManager->flush();

        return $document;
    }

}