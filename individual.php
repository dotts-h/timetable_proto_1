<?php

include_once 'timetable.php';


class Individual
{
    private $chromosome = [];
    private $fintess = -1;


    function __construct($chromosome = null)
    {
        $this->chromosome = $chromosome;
    }

    function initIndividualBasedOnTimetable(Timetable $tt)
    {
        $numSets = $tt->getNumSets();

        $chromosomeLength = $numSets * 3;
        $newChromosome = [];
        $chromosomeIndex = 0;

        foreach ($tt->getGroupsAsArray() as $group) {
            foreach ($group->getModuleIds() as $moduleId) {
                $timeslotId = $tt->getRandomTimeslot()->getTimeslotId();
                $newChromosome[$chromosomeIndex] = $timeslotId;
                $chromosomeIndex++;

                $roomId = $tt->getRandomRoom()->getRoomId();
                $newChromosome[$chromosomeIndex] = $roomId;
                $chromosomeIndex++;

                $module = $tt->getModule($moduleId);
                $newChromosome[$chromosomeIndex] = $module->getRandomProfessorId();
                $chromosomeIndex++;
            }
        }

        $this->chromosome = $newChromosome;
    }

    function initIndividual($chromosomeLength)
    {
        $individual = [];

        for ($gene = 0; $gene < $chromosomeLength; $gene++) {
            $individual[$gene] = $gene;
        }

        $this->chromosome = $individual;
    }

    function getChromosome()
    {
        return $this->chromosome;
    }

    function getChromosomeLength()
    {
        return count($this->chromosome);
    }

    function setGene($offset, $gene)
    {
        $this->chromosome[$offset] = $gene;
    }

    function getGene($offset)
    {
        return $this->chromosome[$offset];
    }

    function setFitness($fitness)
    {
        $this->fitness = $fitness;
    }

    function getFitness()
    {
        return $this->fitness;
    }

    function __toString()
    {
        $output = "";
        for ($gene = 0; $gene < count($this->chromosome); $gene++) {
            $output .= $this->chromosome[$gene] . ',';
        }
        return $output;
    }

    function containsGene($gene)
    {
        for ($i = 0; $i < count($this->chromosome); $i++) {
            if ($this->chromosome[$i] == $gene) {
                return true;
            }
        }
        return false;
    }
}
