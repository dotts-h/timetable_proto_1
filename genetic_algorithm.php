<?php

include_once 'timetable.php';
include_once 'individual.php';
include_once 'helpers.php';
include_once 'population.php';


class GeneticAlgorithm
{
    private $populationSize;
    private $mutationRate;
    private $crossoverRate;
    private $elitismCount;
    private $tournamentSize;


    function __construct($populationSize, $mutationRate, $crossoverRate, $elitismCount, $tournamentSize)
    {
        $this->populationSize = $populationSize;
        $this->mutationRate = $mutationRate;
        $this->crossoverRate = $crossoverRate;
        $this->elitismCount = $elitismCount;
        $this->tournamentSize = $tournamentSize;
    }

    function initPopulation(Timetable $tt)
    {
        $population = new Population();
        $population->initPopulationBasedOnTimetabel($this->populationSize, $tt);
        return $population;
    }

    function isTerminationConditionMetByGenerations($generationCount, $maxGenerations)
    {
        return ($generationCount > $maxGenerations);
    }

    function isTerminationConditionMetByPopulation(Population $population)
    {
        return $population->getFittest(0)->getFitness() == 1.0;
    }



    function calcFitness(Individual $individual, Timetable $tt)
    {
        // $thread = new computeFitness($individual, $tt);
        // $thread->start();

        // $fitness = 1 / (float) ($thread->clashes + 1);

        $timetable = new Timetable($tt);
        $timetable->createSets($individual);

        $clashes = $timetable->calcClashes();
        $fitness = 1 / (float) $clashes + 1;

        $individual->setFitness($fitness);

        return $fitness;
    }

    function evalPopulation(Population $population, Timetable $tt)
    {
        $populationFitness = 0;

        foreach ($population->getIndividuals() as $individual) {
            $populationFitness += $this->calcFitness($individual, $tt);
        }

        $population->setPopulationFitness($populationFitness);
    }

    function selectParent(Population $population)
    {
        $tournament = new Population($this->tournamentSize);

        $population->shuffle();
        for ($i = 0; $i < $this->tournamentSize; $i++) {
            $tournamentIndividual = $population->getIndividual($i);
            $tournament->setIndividual($i, $tournamentIndividual);
        }

        return $tournament->getFittest(0);
    }

    function mutatePopulation(Population $population, Timetable $tt)
    {
        $newPopulation = new Population($this->populationSize);

        for ($populationIndex = 0; $populationIndex < $population->size(); $populationIndex++) {
            $individual = $population->getFittest($populationIndex);

            $randomIndividual = new Individual();
            $randomIndividual->initIndividualBasedOnTimetable($tt);

            for ($geneIndex = 0; $geneIndex < $individual->getChromosomeLength(); $geneIndex++) {
                if ($populationIndex > $this->elitismCount) {
                    if ($this->mutationRate > random()) {
                        $individual->setGene($geneIndex, $randomIndividual->getGene($geneIndex));
                    }
                }
            }

            $newPopulation->setIndividual($populationIndex, $individual);
        }

        return $newPopulation;
    }

    function crossoverPopulation(Population $population)
    {
        $newPopulation = new Population($population->size());

        for ($populationIndex = 0; $populationIndex < $population->size(); $populationIndex++) {
            $parent1 = $population->getFittest($populationIndex);

            if (
                $this->crossoverRate > random() &&
                $populationIndex >= $this->elitismCount
            ) {
                $offspring = new Individual();
                $offspring->initIndividual($parent1->getChromosomeLength());

                $parent2 = $this->selectParent($population);

                for ($geneIndex = 0; $geneIndex < $parent1->getChromosomeLength(); $geneIndex++) {
                    if (0.5 > random()) {
                        $offspring->setGene($geneIndex, $parent1->getGene($geneIndex));
                    } else {
                        $offspring->setGene($geneIndex, $parent2->getGene($geneIndex));
                    }
                }

                $newPopulation->setIndividual($populationIndex, $offspring);
            } else {
                $newPopulation->setIndividual($populationIndex, $parent1);
            }
        }

        return $newPopulation;
    }
}



// class computeFitness extends Thread
// {
//     private Individual $individual;
//     private Timetable $timetable;
//     public $clashes;

//     function __construct(Individual $individual, Timetable $tt)
//     {
//         $this->individual = $individual;
//         $this->timetable = $tt;
//     }

//     function run()
//     {
//         $this->timetable->createSets($this->individual);

//         $this->clashes = $this->timetable->calcClashes();
//     }
// }
