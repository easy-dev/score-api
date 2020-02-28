<?php
namespace App\Controller;

use App\Form\SortingType;
use App\Scores\ScoresService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;


class ScoreController extends AbstractController
{
    /**
     * @var ScoresService
     */
    private ScoresService $scoresService;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(ScoresService $scoresService, SerializerInterface $serializer)
    {
        $this->scoresService = $scoresService;
        $this->serializer = $serializer;
    }
    /**
     * @Route(
     *     "/scores/{gameId}",
     *     name="scores_list",
     *     methods={"GET"},
     *     requirements={
     *         "gameId": "\d+",
     *         "_format": "json",
     *     })
     */
    public function scoresList(int $gameId, Request $request)
    {
        $form = $this->createForm(SortingType::class);
        $form->submit($request->query->all(), false);

        if (!$form->isValid()) {
            $message = $form->getErrors(true)[0]->getMessage();
            throw new BadRequestHttpException($message);
        }
        $sorting = $form->getData();

        $game = $this->scoresService->getGameResults($gameId, $sorting);

        $response = new Response($this->serializer->serialize($game->getScores(), 'json'), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}