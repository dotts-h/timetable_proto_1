<?php


class Population
{
    private $population = [];
    private $populationFitness = -1;


    function __construct()
    {
        // if (!$tt) {
        //     for ($individualCount = 0; $individualCount < $populationSize; $individualCount++) {
        //         $individual = new Individual();
        //         $individual->initIndividualBasedOnTimetable($tt);
        //         $this->population[$individualCount] = $individual;
        //     }
        // }
    }

    function initPopulationBasedOnTimetabel($populationSize, Timetable $tt)
    {
        for ($individualCount = 0; $individualCount < $populationSize; $individualCount++) {
            $individual = new Individual();
            $individual->initIndividualBasedOnTimetable($tt);
            $this->population[$individualCount] = $individual;
        }
    }

    function initPopulation($populationSize, $chromosomeLength)
    {
        for ($individualCount = 0; $individualCount < $populationSize; $individualCount++) {
            $individual = new Individual();
            $individual->initIndividual($chromosomeLength);
            $this->population[$individualCount] = $individual;
        }
    }

    function getIndividuals()
    {
        return $this->population;
    }

    private function compare($o1, $o2)
    {
        if ($o1->getFitness() > $o2->getFitness()) {
            return -1;
        } elseif ($o1->getFitness() < $o2->getFitness()) {
            return 1;
        }
        return 0;
    }

    function getFittest($offset)
    {
        usort($this->population, array("Population", "compare"));

        return $this->population[$offset];
    }

    function setPopulationFitness($fitness)
    {
        $this->populationFitness = $fitness;
    }

    function getPopulationFitnesS()
    {
        return $this->populationFitness;
    }

    function size()
    {
        return count($this->population);
    }

    function setIndividual($offset, Individual $individual)
    {
        return $this->population[$offset] = $individual;
    }

    function getIndividual($offset)
    {
        return $this->population[$offset];
    }

    function shuffle()
    {
        shuffle($this->population);
    }
}
