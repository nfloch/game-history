<?php

namespace App\Model\Enum;

enum GameType: string
{
    case SINGLE_WINNER = 'single_winner';
    case SINGLE_LOOSER = 'single_looser';
    case RANKING_WITHOUT_SCORE = 'ranking_without_score';
    case RANKING_WITH_SCORE = 'ranking_with_score';
    case TEAMS = 'teams';
    case COOPERATION = 'cooperation';
}
