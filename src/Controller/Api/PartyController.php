<?php

namespace App\Controller\Api;

use App\Entity\Game;
use App\Entity\Party;
use App\Entity\Score;
use App\Entity\Team;
use App\Model\Dto\Game\GameDto;
use App\Model\Dto\Party\CreatePartyDto;
use App\Model\Enum\GameType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;


#[Route('/party')]
#[OA\Tag('Party', description: 'All operations for Parties')]
final class PartyController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PlayerRepository $playerRepository
    )
    {
    }

    #[Route('/{gameId}', name: 'app_game_create', methods: ['POST'], format: 'json')]
    #[OA\Response(
        response: 201,
        description: 'The Party Entity',
        content: new Model(type: GameDto::class)
    )]
    public function createPartyForGameWithScores(
        #[MapEntity(mapping: ['gameId' => 'id'])] Game $game,
        #[MapRequestPayload] CreatePartyDto $createPartyDto,
    ): JsonResponse
    {
        $party = new Party();
        $party->setGame($game);

        foreach ($createPartyDto->teams as $createTeamWithScoreDto) {
            $team = new Team();

            foreach ($createTeamWithScoreDto->teamPlayersWithScores as $createTeamPlayerWithScoreDto) {
                $player = $this->playerRepository->find($createTeamPlayerWithScoreDto->playerId);
                if (null === $player) {
                    throw $this->createNotFoundException("Player with id {$createTeamPlayerWithScoreDto->playerId} was not found");
                }
                $team->addPlayer($player);
                if (null !== $createTeamPlayerWithScoreDto->score || null !== $createTeamPlayerWithScoreDto->rank || null !== $createTeamPlayerWithScoreDto->isWinner) {
                    $score = new Score();
                    $score
                        ->setPlayer($player)
                        ->setScore($createTeamPlayerWithScoreDto->score)
                        ->setRank($createTeamPlayerWithScoreDto->rank)
                        ->setIsWinner($createTeamPlayerWithScoreDto->isWinner)
                    ;
                    $this->entityManager->persist($score);
                }
            }
            if (null !== $createTeamWithScoreDto->score || null !== $createTeamWithScoreDto->rank || null !== $createTeamWithScoreDto->isWinner) {
                $score = new Score();
                $score
                    ->setTeam($team)
                    ->setScore($createTeamWithScoreDto->score)
                    ->setRank($createTeamWithScoreDto->rank)
                    ->setIsWinner($createTeamWithScoreDto->isWinner)
                ;
                $this->entityManager->persist($score);
            }
            $this->entityManager->persist($team);
        }

        $this->entityManager->persist($party);



        return $this->json([], 201);
    }
}
