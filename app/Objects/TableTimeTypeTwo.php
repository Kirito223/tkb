<?php

namespace App\Objects;

class TableTimeTypeTwo extends ObjectClass
{
    private $teacher;
    private $tableTimeMorning;
    private $tableTimeAfterNoon;

    public function __construct($teacher, $tableTimeMorning, $tableTimeAfterNoon)
    {
        $this->teacher = $teacher;
        $this->tableTimeMorning = $tableTimeMorning;
        $this->tableTimeAfterNoon = $tableTimeAfterNoon;
    }

    public function getTeacher()
    {
        return $this->teacher;
    }
    public function getTableTimeMorning()
    {
        return $this->tableTimeMorning;
    }

    public function getTableTimeAfterNoon()
    {
        return $this->tableTimeAfterNoon;
    }
}
