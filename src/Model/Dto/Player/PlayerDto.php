<?php

namespace App\Model\Dto\Player;

use App\Entity\Player;

final readonly class PlayerDto
{
    public int $id;
    public string $name;

    public static function fromEntity(Player $player): self
    {
        $self = new self();
        $self->id = $player->getId();
        $self->name = $player->getName();

        return $self;
    }
}
