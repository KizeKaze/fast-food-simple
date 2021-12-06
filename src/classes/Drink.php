<?php

namespace App\Classes;

/*
 * Base class that will hold various information about our drink menu
 */
class Drink
{
    private string $name = '';
    private string $description = '';
    private float $cost = 0;
    private int $type =  0;
    
    public function __construct() {}
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    
    public function getCost(): float
    {
        return $this->cost;
    }
    
    public function setCost(float $cost): void
    {
        $this->cost = $cost;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }
}
