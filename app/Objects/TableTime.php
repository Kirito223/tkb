<?php

namespace App\Objects;

use App\Objects\ObjectClass;

class TableTime extends ObjectClass
{
    private $day;
    private $session;
    private $subject;
    private $name;

    public function __construct($day = null, $session = 0,  $subject = 0,  $name = null)
    {
        $this->day = $day;
        $this->session = $session;
        $this->subject = $subject;
        $this->name = $name;
    }

    public function getSubject()
    {
        return $this->subject;
    }
    public function getName()
    {
        return $this->name;
    }

}
