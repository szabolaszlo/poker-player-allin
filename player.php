<?php

class Player
{
    const VERSION = "TEAM ALL IN";

    public function betRequest($game_state)
    {
        sleep(20);
        $bet = $game_state['current_buy_in'] - $game_state[$game_state['in_action']]['bet'];
        return max($bet, $game_state['small_blind']);
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
