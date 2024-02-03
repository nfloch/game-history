<?php

namespace App\Controller\Api;

use App\Entity\Game;
use App\Model\Dto\Game\CreateGameDto;
use App\Model\Dto\Game\GameDto;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/game')]
#[OA\Tag('Game', description: 'All operations for Games')]
final class GameController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly GameRepository         $gameRepository,
    )
    {
    }

    #[Route(name: 'app_game_create', methods: ['POST'], format: 'json')]
    #[OA\Response(
        response: 201,
        description: 'The Game Entity',
        content: new Model(type: GameDto::class)
    )]
    public function create(
        #[MapRequestPayload] CreateGameDto $createGameDto
    ): JsonResponse
    {
        $game = new Game();
        $game->setName($createGameDto->name);
        $game->setType($createGameDto->type);

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return $this->json(GameDto::fromEntity($game), 201);
    }

    #[Route(name: 'app_game_get_all', methods: ['get'], format: 'json')]
    #[OA\Response(
        response: 200,
        description: 'All games',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: GameDto::class))
        )
    )]
    public function getAll(): JsonResponse
    {
        return $this->json(
            array_map(static fn (Game $game) => GameDto::fromEntity($game),
                $this->gameRepository->findAll()
            )
        );
    }

    #[Route('/{id}', name: 'app_game_find', requirements: ['id' => '\d+'], methods: ['get'], format: 'json')]
    #[OA\Response(
        response: 200,
        description: 'The game Entity',
        content: new Model(type: GameDto::class)
    )]
    public function findOne(Game $game): JsonResponse
    {
        return $this->json(GameDto::fromEntity($game));
    }

    #[Route('/{id}', name: 'app_game_delete', requirements: ['id' => '\d+'], methods: ['DELETE'], format: 'json')]
    #[OA\Delete(description: 'Delete game by Id')]
    #[OA\Response(
        response: 204,
        description: 'No content'
    )]
    public function delete(Game $game): JsonResponse
    {
        $this->entityManager->remove($game);
        $this->entityManager->flush();
        return $this->json([], 204);
    }
}
