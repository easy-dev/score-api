<?php

namespace spec\App\Scores;

use App\Document\Game;
use App\Document\GamePersistance;
use App\Scores\External\Score;
use App\Scores\ScoreProviderInterface;
use App\Scores\Sorting;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\EventManager;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Hydrator\HydratorFactory;
use Doctrine\ODM\MongoDB\PersistentCollection;
use Doctrine\ODM\MongoDB\UnitOfWork;
use Doctrine\Persistence\ObjectRepository;
use MongoDB\Collection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScoresServiceSpec extends ObjectBehavior
{
    const GAME_ID = '123';

    function let(
        ScoreProviderInterface $scoreProvider,
        DocumentManager $dm,
        GamePersistance $gamePersistance,
        ObjectRepository $objectRepository
    ) {
        $dm->getRepository(Game::class)->willReturn($objectRepository);
        $this->beConstructedWith($scoreProvider, $dm, $gamePersistance);
    }

    function it_retrives_games_from_api_if_no_games_cached(
        Sorting $sorting,
        ObjectRepository $objectRepository,
        Game $game,
        ScoreProviderInterface $scoreProvider,
        GamePersistance $gamePersistance,
        Score $score
    ) {
        $objectRepository->findOneBy(['gameId' => self::GAME_ID])->willReturn($game);
        $game->isCompleted()->willReturn(false);

        $scoreProvider->getGameResults(self::GAME_ID)->willReturn([ $score]);
        $gamePersistance->persistGames(self::GAME_ID, [$score])->willReturn($game);

        $this->getGameResults(self::GAME_ID, $sorting)->shouldReturn($game);
    }

    function it_retrives_games_from_external_and_apply_sorting_descending(
        Sorting $sorting,
        ObjectRepository $objectRepository,
        Game $game,
        ScoreProviderInterface $scoreProvider,
        GamePersistance $gamePersistance,
        Score $score1,
        Score $score2
    ) {
        $objectRepository->findOneBy(['gameId' => self::GAME_ID])->willReturn($game);
        $game->isCompleted()->willReturn(false);

        $scoreProvider->getGameResults(self::GAME_ID)->willReturn([$score1, $score2]);
        $gamePersistance->persistGames(self::GAME_ID, [$score1, $score2])->willReturn($game);

        $score1->getScore()->willReturn(100);
        $score2->getScore()->willReturn(50);

        $configuration = new Configuration();
        $configuration->setHydratorDir(sys_get_temp_dir());
        $configuration->setHydratorNamespace("App\Document");
        $game->getScores()->willReturn(new PersistentCollection(new ArrayCollection([$score1->getWrappedObject(), $score2->getWrappedObject()]),
            DocumentManager::create(null, $configuration),
            new UnitOfWork(DocumentManager::create(null, $configuration), new EventManager(),
                new HydratorFactory(DocumentManager::create(null, $configuration), new EventManager(), sys_get_temp_dir(),"App\Document", false))));

        $game->setScores(Argument::any())->shouldBeCalled();
        $game = $this->getGameResults(self::GAME_ID, new Sorting('score', Sorting::DESC));
        $game->getScores()->first()->getScore()->shouldReturn(100);
        $game->getScores()->next()->getScore()->shouldReturn(50);
    }

    function it_retrives_games_from_external_and_apply_sorting_ascending(
        Sorting $sorting,
        ObjectRepository $objectRepository,
        Game $game,
        ScoreProviderInterface $scoreProvider,
        GamePersistance $gamePersistance,
        Score $score1,
        Score $score2
    ) {
        $objectRepository->findOneBy(['gameId' => self::GAME_ID])->willReturn($game);
        $game->isCompleted()->willReturn(false);

        $scoreProvider->getGameResults(self::GAME_ID)->willReturn([$score2, $score1]);
        $gamePersistance->persistGames(self::GAME_ID, [$score2, $score1])->willReturn($game);

        $score1->getScore()->willReturn(100);
        $score2->getScore()->willReturn(50);

        $configuration = new Configuration();
        $configuration->setHydratorDir(sys_get_temp_dir());
        $configuration->setHydratorNamespace("App\Document");
        $game->getScores()->willReturn(new PersistentCollection(new ArrayCollection([$score2->getWrappedObject(), $score1->getWrappedObject()]),
            DocumentManager::create(null, $configuration),
            new UnitOfWork(DocumentManager::create(null, $configuration), new EventManager(),
                new HydratorFactory(DocumentManager::create(null, $configuration), new EventManager(), sys_get_temp_dir(),"App\Document", false))));

        $game->setScores(Argument::any())->shouldBeCalled();
        $game = $this->getGameResults(self::GAME_ID, new Sorting('score', Sorting::ASC));
        $game->getScores()->first()->getScore()->shouldReturn(50);
        $game->getScores()->next()->getScore()->shouldReturn(100);
    }
}
