<?php

namespace App\Model\Dto\Party;

final readonly class TeamWithScoreDto
{
    /**
     * @param array<TeamPlayerWithScoreDto> $teamPlayersWithScores
     */
    public function __construct(
        public ?bool $isWinner,
        public ?int $rank,
        public ?int $score,
        public array $teamPlayersWithScores,
    )
    {
    }
}
