<?php

class Player
{
    const VERSION = "TEAM ALL IN";

    protected $preFlopStrategy;

    protected $ranking;

    protected $rankIdMultiplyer;

    public function __construct()
    {
        $this->preFlopStrategy = new PreFlopStrategy();
        $this->ranking = new Ranking();
        $this->rankIdMultiplyer = new RankIdMultiplyer();
    }

    public function betRequest($game_state)
    {

        if (empty($game_state['community_cards'])) {
            return (int) $this->getBetBeforeFlop($game_state);
        } else {
            return $this->getBetAfterFlop($game_state);
        }

    }

    public function getBetBeforeFlop($game_state)
    {
        $player = $game_state['players'][$game_state['in_action']];

        $decision = $this->preFlopStrategy->getAction($player['hole_cards']);


        switch ($decision) {
            case 'raise':
                if ($game_state['pot'] > $player['stack'] * 0.7) {
                    return $player['stack'];
                }
                return $game_state['pot'];
            case 'allin':
                return (int)$player['stack'];
            case 'blind':
                return 0;
            //case 'raise':
            case 'limp':

                $call = (int)$game_state['current_buy_in'] - $player['bet'];

                if (
                    (int)$game_state['pot'] <= ($game_state['small_blind'] * 4)
                    || (
                        $call <= ($game_state["small_blind"] * 8)
                        && $call <= (int)$player["stack"] * 0.2
                    )
                ) {
                    return $call;
                }

                return 0;
            case 'fold':
                return 0;
            default:
                return 0;
        }
    }

    public function getBetAfterFlop($game_state)
    {

        $player = $game_state['players'][$game_state['in_action']];

        $ranking = $this->ranking->rankCards((array)$player['hole_cards'], (array)$game_state['community_cards']);

        $minimumBet = $game_state['current_buy_in'] - $player['bet'] + $game_state['minimum_raise'];

        $bet = $this->rankIdMultiplyer->getMultiply($ranking, $player['stack']);

        if($bet){
            return max($bet, $minimumBet);
        }

        if (
            $game_state['dealer'] == $game_state['in_action']
            && ($game_state["current_buy_in"] - $player["bet"] == 0)
        ) {
            return $minimumBet;
        }

        return 0;

    }

    public function showdown($game_state)
    {
    }

    public function getMe($game_state)
    {
        foreach ($game_state["players"] as $player) {
            if ($player["version"] === self::VERSION) {
                return $player;
            }
        }
    }
}
