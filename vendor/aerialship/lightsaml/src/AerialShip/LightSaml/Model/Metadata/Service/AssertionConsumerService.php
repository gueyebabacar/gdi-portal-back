<?php

namespace AerialShip\LightSaml\Model\Metadata\Service;

use AerialShip\LightSaml\Error\InvalidXmlException;
use AerialShip\LightSaml\Meta\SerializationContext;


class AssertionConsumerService extends AbstractService
{
    /** @var int */
    protected $index;


    function __construct($binding = null, $location = null, $index = null) {
        parent::__construct($binding, $location);
        if ($index !== null) {
            $this->setIndex($index);
        }
    }


    /**
     * @param int $index
     * @throws \InvalidArgumentException
     */
    public function setIndex($index) {
        $v = intval($index);
        if ($v != $index) {
            throw new \InvalidArgumentException("Expected int got $index");
        }
        $this->index = $index;
    }

    /**
     * @return int
     */
    public function getIndex() {
        return $this->index;
    }


    protected function getXmlNodeName() {
        return 'AssertionConsumerService';
    }

    /**
     * @param \DOMNode $parent
     * @param \AerialShip\LightSaml\Meta\SerializationContext $context
     * @return \DOMElement
     */
    function getXml(\DOMNode $parent, SerializationContext $context) {
        $result = $result = parent::getXml($parent, $context);
        $result->setAttribute('index', $this->getIndex());
        return $result;
    }

    /**
     * @param \DOMElement $xml
     * @throws \AerialShip\LightSaml\Error\InvalidXmlException
     */
    function loadFromXml(\DOMElement $xml) {
        parent::loadFromXml($xml);
        if (!$xml->hasAttribute('index')) {
            throw new InvalidXmlException("Missing index attribute");
        }
        $this->setIndex($xml->getAttribute('index'));
    }





}