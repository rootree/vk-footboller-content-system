<?php
/**
 * User: Ivan Chura <ivan.chura@gmail.com>
 * Date: 19.08.2010
 * Time: 14:39:11
 */ 
class LevelEntity {

    private $level;
    private $nextExperiance;
    private $studyPoints;
    private $baseEnergy;

    function __construct($level, $nextExperiance, $energy, $studyPoints) {
        $this->level = $level;
        $this->nextExperiance = $nextExperiance;
        $this->studyPoints = $studyPoints;
        $this->baseEnergy = $energy;
    }

    public function getLevel(){
        return $this->level;
    }

    public function getNextLevelExp(){
        return $this->nextExperiance;
    }

    public function getStudyPoints(){
        return $this->studyPoints;
    }

    public function getBaseEnergy(){
        return $this->baseEnergy;
    }
}

?>

