<?php
namespace App\Scores;

interface ScoreProviderInterface
{
    public function getGameResults(int $gameId): array;
}