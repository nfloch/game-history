<?php

namespace App\Model\Dto\Party;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateTeamPlayerWithScoreDto
{
    public function __construct(
        #[Assert\Positive]
        public int $playerId,

        public ?bool $isWinner = null,
        public ?int $rank = null,
        public ?int $score = null,
    )
    {
    }
}
