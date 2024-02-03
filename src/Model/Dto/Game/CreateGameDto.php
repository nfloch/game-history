<?php

namespace App\Model\Dto\Game;

use App\Model\Enum\GameType;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateGameDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,

        #[Assert\NotBlank]
        public GameType $type,
    )
    { }
}
