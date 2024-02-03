<?php

namespace App\Controller\Api;

use App\Entity\Player;
use App\Model\Dto\Player\CreatePlayerDto;
use App\Model\Dto\Player\PlayerDto;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/player')]
#[OA\Tag('Player', description: 'All operations for players')]
final class PlayerController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PlayerRepository $playerRepository,
    )
    {
    }

    #[Route(name: 'app_player_create', methods: ['POST'], format: 'json')]
    #[OA\Post(description: 'Create a Player')]
    #[OA\Response(
        response: 201,
        description: 'The player Entity',
        content: new Model(type: PlayerDto::class)
    )]
    public function create(
        #[MapRequestPayload] CreatePlayerDto $createPlayerDto
    ): JsonResponse
    {
        $player = new Player();
        $player->setName($createPlayerDto->name);
        $this->entityManager->persist($player);
        $this->entityManager->flush();

        return $this->json(PlayerDto::fromEntity($player), 201);
    }

    #[Route(name: 'app_player_get_all', methods: ['get'], format: 'json')]
    #[OA\Get(description: 'Get all players')]
    #[OA\Response(
        response: 200,
        description: 'All players',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: PlayerDto::class))
        )
    )]
    public function getAll(): JsonResponse
    {
        return $this->json(
            array_map(static fn (Player $player) => PlayerDto::fromEntity($player),
                $this->playerRepository->findAll()
            )
        );
    }

    #[Route('/{id}', name: 'app_player_find', requirements: ['id' => '\d+'], methods: ['get'], format: 'json')]
    #[OA\Get(description: 'Get a player by Id')]
    #[OA\Response(
        response: 200,
        description: 'The player Entity',
        content: new Model(type: PlayerDto::class)
    )]
    public function findOne(Player $player): JsonResponse
    {
        return $this->json(PlayerDto::fromEntity($player));
    }

    #[Route('/{id}', name: 'app_player_delete', requirements: ['id' => '\d+'], methods: ['DELETE'], format: 'json')]
    #[OA\Delete(description: 'Delete player by Id')]
    #[OA\Response(
        response: 204,
        description: 'No content'
    )]
    public function delete(Player $player): JsonResponse
    {
        $this->entityManager->remove($player);
        $this->entityManager->flush();
        return $this->json([], 204);
    }
}
