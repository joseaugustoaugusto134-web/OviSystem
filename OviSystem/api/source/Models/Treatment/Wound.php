<?php

namespace Source\Models\Treatment;
use Source\Core\Model;
use Source\Core\Connect;

class Wound extends Model
{
    private ?int $id;
    private ?int $sheepsId;
    private ?string $description;
    private ?string $date;
    private ?string $location;
    private ?string $situation;
    private ?string $severity;
    private ?string $treatment;
    private ?string $observation;
    private ?int $active;

    public function __construct()
    {
        
    }
 

}