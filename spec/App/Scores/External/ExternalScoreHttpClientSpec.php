<?php

namespace spec\App\Scores\External;

use App\Document\Score;
use App\Scores\External\ExternalScoreHttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\SerializerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExternalScoreHttpClientSpec extends ObjectBehavior
{
    const GAME_ID = 123;

    function let(Client $client, SerializerInterface $serializer)
   {
       $this->beConstructedWith($client, $serializer);
   }

    function it_throws_exception_if_client_fails(Client $client)
    {
        $client->get(ExternalScoreHttpClient::RESULTS_ENDPOINT . self::GAME_ID)->willThrow(BadResponseException::class);

        $this->shouldThrow(NotFoundHttpException::class)->during('getGameResults',[self::GAME_ID]);
    }

   function it_calls_http_client_and_get_results(Client $client, SerializerInterface $serializer, Response $response, Score $score)
   {
       $client->get(ExternalScoreHttpClient::RESULTS_ENDPOINT . self::GAME_ID)->willReturn($response);
       $response->getBody()->willReturn("[
        {
        \"id\": \"a227380b-890b-4265-b26a-d5c8849c281a\",
        \"user\": {
        \"name\": \"Leona Everett\",
        \"id\": \"9f4139ac-1b7a-43e2-95e3-a94f94b17571\"
        },
        \"score\": 5,
        \"finished_at\": \"2020-02-27T11:25:00+00:00\"
        }
        ]");
        $score->getScore()->willReturn(5);
       $serializer->deserialize(Argument::cetera())->willReturn([$score]);
       $results = $this->getGameResults(self::GAME_ID);
       $results[0]->getScore()->shouldReturn(5);
   }
}
