<?php
namespace App\Scores\External;

use App\Scores\ScoreProviderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExternalScoreHttpClient implements ScoreProviderInterface
{
    const RESULTS_ENDPOINT = "/results/games/";
    /**
     * @var Client
     */
    private Client $client;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(Client $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function getGameResults(int $gameId): array
    {
        try {
            $response = $this->client->get(self::RESULTS_ENDPOINT . $gameId);
        } catch (BadResponseException $exception) {
            throw new NotFoundHttpException();
        }
        return $this->serializer->deserialize($response->getBody(),"array<App\Scores\External\Score>", 'json');
    }
}