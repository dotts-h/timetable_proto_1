<?php


class Room
{
    private $roomId;
    private $roomNumber;
    private $capacity;

    function __construct($roomId, $roomNumber, $capacity)
    {
        $this->roomId = $roomId;
        $this->roomNumber = $roomNumber;
        $this->capacity = $capacity;
    }

    function getRoomId()
    {
        return $this->roomId;
    }

    function getRoomNumber()
    {
        return $this->roomNumber;
    }

    function getRoomCapacity()
    {
        return $this->capacity;
    }
}
