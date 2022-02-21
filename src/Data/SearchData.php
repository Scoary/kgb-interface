<?php

namespace App\Data;


use App\Entity\Countries;
use App\Entity\Skills;

class SearchData
{
    /**
    * @var string
    */
    public $q = "";

    /**
    * @var Countries
    */
    public $country = [];

    /**
    * @var Skills
    */
    public $skill = [];


    /**
     * @var int
     */
    public $page = 1;


}