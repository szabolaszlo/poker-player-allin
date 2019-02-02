<?php
/**
 * Created by PhpStorm.
 * User: szabolaszlo
 * Date: 2019.02.02.
 * Time: 10:51
 */

use GuzzleHttp\Client;

class Ranking
{
    protected $httpClient;

    const RANKING_API = 'http://rainman.leanpoker.org/rank';

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function rankCards(array $playerCards, array $communityCards)
    {
        $cards = [
            'cards' => json_encode(array_merge($playerCards, $communityCards)),
        ];
        try {
            $resp = $this->httpClient->get(self::RANKING_API, [
                'form_params' => $cards,
            ]);
            $ranking = json_decode($resp->getBody(), true);
        }catch (Throwable $throwable){
            $ranking = array();
        }catch (Exception $throwable){
            $ranking = array();
        }
        $ranking['player_cards'] = $playerCards;
        $ranking['community_cards'] = $communityCards;
        $i = 0;
        foreach ($playerCards as $playerCard) {
            foreach ($communityCards as $communityCard) {
                if ($playerCard['rank'] == $communityCard['rank']) {
                    $i++;
                    if ($i === 2) {
                        break 2;
                    }
                }
            }
        }
        $ranking['strength'] = $i;
        return $ranking;
    }
}