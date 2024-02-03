<?php

namespace App\Model\Dto\Party;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreatePartyDto {
    /**
     * @param array<CreateTeamWithScoreDto> $teams
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\All(new Assert\Type(CreateTeamWithScoreDto::class))]
        public array $teams,
    )
    {
    }
}
