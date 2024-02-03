<?php

namespace App\Model\Dto\Player;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreatePlayerDto
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
    )
    {
    }
}
