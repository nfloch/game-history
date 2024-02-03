<?php

namespace App\Model\Dto\Party;

use App\Entity\Party;
use App\Entity\Team;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class PartyDto {
    public int $gameId;
    /**
     * @var array<TeamWithScoreDto> $teams
     */
    public array $teams;

    public static function fromEntity(Party $party): self
    {
        $self = new self();
        $self->gameId = $party->getGame()->getId();

        array_map(static function (Team $team) {
            $teamDto = new TeamWithScoreDto(
            );
        }, $party->getTeams()->getValues());
        return $self;
    }
}
