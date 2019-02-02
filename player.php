<?php

class Player
{
    const VERSION = "TEAM ALL IN";

    protected $preFlopStrategy;

    public function __construct()
    {
        $this->preFlopStrategy = new PreFlopStrategy();
    }

    public function betRequest($game_state)
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
                return (int)($player['stack'] / 2);
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
