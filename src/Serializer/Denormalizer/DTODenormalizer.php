<?php

namespace App\Serializer\Denormalizer;

use App\DTO\SerializerTestDTO;
use Symfony\Component\PropertyInfo\Extractor\SerializerExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DTODenormalizer implements DenormalizerInterface
{
    private $propertyInfoExtractor;

    /**
     * DTODenormalizer constructor.
     * @param PropertyInfoExtractorInterface $propertyInfo
     */
    public function __construct(PropertyInfoExtractorInterface $propertyInfo)
    {
        $this->propertyInfoExtractor = $propertyInfo;
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data Data to restore
     * @param string $class The expected class to instantiate
     * @param string $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     *
     * @return object
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     * @throws ExceptionInterface       Occurs for all the other cases of errors
     */
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        $object = new SerializerTestDTO;

        $objectProperties = $this->propertyInfoExtractor->getProperties(SerializerTestDTO::class);
        $dataKeys = array_keys($data);

        $objectPropertiesToSet = array_intersect($objectProperties, $dataKeys);

        foreach ($objectPropertiesToSet as $property) {
            $propertyInfo = $this->propertyInfoExtractor->getTypes(SerializerTestDTO::class, $property);
            $object->$property = $this->castValue($propertyInfo, $data[$property]);
        }

        return $object;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed $data Data to denormalize from
     * @param string $type The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === SerializerTestDTO::class;
    }

    /**
     * @param array|Type[] $propertyInfo
     * @param string $value
     * @return mixed
     */
    private function castValue(?array $propertyInfo, string $value)
    {
        if ($propertyInfo === null) {
            return null;
        }

        switch ($propertyInfo[0]->getBuiltinType()) {
            case 'int':
                return (int)$value;
            case 'float':
                return (float)$value;
            default:
                return (string)$value;
        }
    }
}
