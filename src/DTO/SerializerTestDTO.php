<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class SerializerTestDTO
{
    /**
     * @var int
     * @SerializedName("unique-id")
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