<?php

namespace App\Model\Dto\Party;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateTeamWithScoreDto
{
    /**
     * @param array<CreateTeamPlayerWithScoreDto> $teamPlayersWithScores
     */
    public function __construct(
        public ?bool $isWinner,
        public ?int $rank,
        public ?int $score,

        #[Assert\NotBlank]
        #[Assert\All(new Assert\Type(CreateTeamPlayerWithScoreDto::class))]
        public array $teamPlayersWithScores,
    )
    {
    }
}
