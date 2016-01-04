<?php
/**
 * User: Ivan Chura <ivan.chura@gmail.com>
 * Date: 19.08.2010
 * Time: 14:38:53
 */ 
class LevelGrid {

    private $levelGrid;

    private static $instance;

    function __construct(){

        $this->levelGrid[] = new LevelEntity(0,0,0, 17);
        $this->levelGrid[] = new LevelEntity(1, 20, 100, 5);
        $this->levelGrid[] = new LevelEntity(2, 40, 120, 5);
        $this->levelGrid[] = new LevelEntity(3, 70, 130, 5);
        $this->levelGrid[] = new LevelEntity(4, 100, 140, 7);
        $this->levelGrid[] = new LevelEntity(5, 130, 150, 7);
        $this->levelGrid[] = new LevelEntity(6, 160, 160, 7);

    }

    public static function getInstance(){
        if(!LevelsGrid::$instance){
            LevelsGrid::$instance = new LevelsGrid();
        }
        return LevelsGrid::$instance;
    }

    public function getNextLevelExp($level){
        $levelEntity = $this->levelGrid[$level];
        return $levelEntity->getNextLevelExp();
    }

    public function getStudyPoints($level){
        $levelEntity = $this->levelGrid[$level];
        return $levelEntity->getStudyPoints();
    }

    public function getBaseEnergy($level){
        $levelEntity = $this->levelGrid[$level];
        return $levelEntity->getBaseEnergy();
    }

    public function levelExist($level) {
        return isset($this->levelGrid[$level]);
    }
}