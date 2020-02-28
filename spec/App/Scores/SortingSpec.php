<?php

namespace spec\App\Scores;

use App\Document\Score;
use App\Scores\Sorting;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SortingSpec extends ObjectBehavior
{
    function it_throws_exception_if_sort_order_is_incorrect()
    {
        $this->shouldThrow(BadRequestHttpException::class)->during("__construct", ['sorting', "RANDOM"]);
    }

    function it_sorts_array_collection_asc(Sorting $sorting, Score $score1, Score $score2)
    {
        $this->beConstructedWith('score', Sorting::ASC);

        $score1->getScore()->willReturn(100);
        $score2->getScore()->willReturn(50);

        $scoresCollection = $this->sort([$score1->getWrappedObject(), $score2->getWrappedObject()]);
        $scoresCollection->first()->getScore()->shouldReturn(50);
        $scoresCollection->next()->getScore()->shouldReturn(100);
    }

    function it_sorts_array_collection_desc(Sorting $sorting, Score $score1, Score $score2)
    {
        $this->beConstructedWith('score', Sorting::DESC);

        $score1->getScore()->willReturn(50);
        $score2->getScore()->willReturn(100);

        $scoresCollection = $this->sort([$score1->getWrappedObject(), $score2->getWrappedObject()]);
        $scoresCollection->first()->getScore()->shouldReturn(100);
        $scoresCollection->next()->getScore()->shouldReturn(50);
    }
}
