<?php

class Timeslot
{
    private $timeslotId;
    private $timeslot;

    function __construct($timeslotId, $timeslot)
    {
        $this->timeslotId = $timeslotId;
        $this->timeslot = $timeslot;
    }

    function getTimeslotId()
    {
        return $this->timeslotId;
    }

    function getTimeslot()
    {
        return $this->timeslot;
    }
}
