<?php

namespace App\Model\Dto\Game;

use App\Entity\Game;
use App\Model\Enum\GameType;

final readonly class GameDto
{
    public int $id;
    public string $name;
    public GameType $type;

    public static function fromEntity(Game $game): self
    {
        $self = new self();
        $self->id = $game->getId();
        $self->name = $game->getName();
        $self->type = $game->getType();

        return $self;

    }

}
