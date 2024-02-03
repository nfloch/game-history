<?php

namespace App\Model\Dto\Party;

final readonly class TeamPlayerWithScoreDto
{
    public function __construct(
        public int $playerId,
        public ?bool $isWinner = null,
        public ?int $rank = null,
        public ?int $score = null,
    )
    {
    }
}
