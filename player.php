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

        if (empty($game_state['community_cards'])){
            return $this->getBetBeforeFlop($game_state);
        }else{
            return $this->getBetAfterFlop($game_state);
        }


    }

    public function getBetBeforeFlop($game_state)
    {
        $player = $game_state['players'][$game_state['in_action']];

        $decision = $this->preFlopStrategy->getAction($player['hole_cards']);

//        $ranking = $this->ranking->rankCards((array)$player['hole_cards'], (array)$game_state['community_cards']);

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
                return 0;
            case 'fold':
                return 0;
            default:
                return 0;
        }
    }

    public function getBetAfterFlop($game_state)
    {
        return $this->getBetBeforeFlop($game_state);
        /*
        $player = $game_state['players'][$game_state['in_action']];

        return $this->rankIdMultiplyer->getMultiply($rank,$player['stack']);
        */
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
