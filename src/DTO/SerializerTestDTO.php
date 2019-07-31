<?php

namespace App\DTO;

class SerializerTestDTO
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var float
     */
    public $float;

    /**
     * @var string
     */
    public $key;

    public $randomVarWithoutType;

    /**
     * @var string
     */
    public $randomVarWithType;

    /**
     * @var \stdClass
     */
    public $stdObj;
}