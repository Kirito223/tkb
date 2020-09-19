<?php

namespace App\Objects;

use Session;

class SessionInfo
{
    private $schoolId;
    private $schoolName;
    public function __construct()
    {
        $this->schoolId = Session::get('matruong');
        $this->schoolName = Session::get('tentruong');
    }
    public function getSchoolId()
    {
        return $this->schoolId;
    }
    public function getSchoolName()
    {
        return $this->schoolName;
    }
}
