<?php

require_once(dirname(__FILE__) . '/../darts.php');

class Game {

    protected $id;
    protected $date;
    protected $winner;
    protected $losers = array();
    protected $changes = array();

    public function __construct($id, $date, $winner = null, $losers = array()) {
        $this->id = $id;
        $this->date = $date;
        $this->winner = $winner;
        $this->losers = $losers;
    }

    public function id() {
        return $this->id;
    }

    public function date() {
        return $this->date;
    }

    public function winner() {
        return $this->winner;
    }

    public function losers() {
        return $this->losers;
    }

    protected function loser($toFind) {
        foreach ($this->losers as $loser) {
            if ($loser->id() === $toFind->id()) {
                return $loser;
            }
        }
    }

    public function players() {
        return array_merge(array($this->winner), $this->losers);
    }

    public function setWinner($winner) {
        if (!is_null($this->winner)) {
            throw new Exception('Second winner added');
        }
        $this->winner = $winner;
    }

    public function addLoser($loser) {
        $this->losers[] = $loser;
    }

    public function change($player) {
        if (!$this->changes) {
            $this->resolve();
        }
        return $this->changes[$player->id()];
    }

    protected function resolve() {
        if ($this->changes) {
            return;
        }
        if (!$this->winner || !$this->losers) {
            throw new Exception("Cannot process an invalid game.");
        }
        $this->changes[$this->winner->id()] = 0;
        $this->winner->played += 1;
        $this->winner->streak += 1;
        $winnerInitialRating = $this->winner->rating;
        foreach ($this->losers as $loser) {
            $loser->played += 1;
            $loser->streak = 0;
            $change = $this->calculateChange($winnerInitialRating, $loser->rating);
            $this->changes[$this->winner->id()] += $change;
            $this->changes[$loser->id()] = -$change;
            $this->winner()->rating += $change;
            $loser->rating -= $change;
            if ($loser->rating < MINIMUM_RATING) {
                $loser->rating = MINIMUM_RATING;
            }
        }
    }

    protected function calculateChange($winnerRating, $loserRating) {
        $totalRating = $winnerRating + $loserRating;
        $multiplier = GAME_VALUE / $totalRating;
        return max(1, (int) ($multiplier * $loserRating));
    }

}
