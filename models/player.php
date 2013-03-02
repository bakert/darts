<?php

class Player {

    public $rating;
    public $played;
    public $streak;

    protected $id;
    protected $name;

    public function __construct($id, $name, $rating = INITIAL_RATING, $played = 0, $streak = 0) {
        $this->id = $id;
        $this->name = $name;
        $this->rating = $rating;
        $this->played = $played;
        $this->streak = $streak;
    }

    public function id() {
        return $this->id;
    }

    public function name() {
        return $this->name;
    }

    public function copy() {
        return unserialize(serialize($this));
    }

}
