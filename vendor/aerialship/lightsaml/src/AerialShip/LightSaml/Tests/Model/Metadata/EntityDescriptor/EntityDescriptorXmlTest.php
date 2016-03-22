<?php

namespace AerialShip\LightSaml\Tests\EntityDescriptor;

use AerialShip\LightSaml\Bindings;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\Metadata\EntityDescriptor;
use AerialShip\LightSaml\Model\Metadata\IdpSsoDescriptor;
use AerialShip\LightSaml\Model\Metadata\KeyDescriptor;
use AerialShip\LightSaml\Model\Metadata\Service\AssertionConsumerService;
use AerialShip\LightSaml\Model\Metadata\Service\SingleLogoutService;
use AerialShip\LightSaml\Model\Metadata\Service\SingleSignOnService;
use AerialShip\LightSaml\Model\Metadata\SpSsoDescriptor;
use AerialShip\LightSaml\Protocol;
use AerialShip\LightSaml\Security\X509Certificate;


class EntityDescriptorXmlTest extends \PHPUnit_Framework_TestCase
{

    function testOne() {
        $entityID = 'http://example.com';
        $locationLogout = 'http://example.com/logout';
        $locationLogin = 'http://example.com/login';
        $certificate = new X509Certificate();
        $certificate->loadFromFile(__DIR__.'/../../../../../../../resources/sample/Certificate/saml.crt');
        $ed = new EntityDescriptor(
            $entityID,
            array(
                new SpSsoDescriptor(
                    array(
                        new SingleLogoutService(Bindings::SAML2_HTTP_REDIRECT, $locationLogout),
                        new AssertionConsumerService(Bindings::SAML2_HTTP_POST, $locationLogin, 0),
                        new AssertionConsumerService(Bindings::SAML2_HTTP_ARTIFACT, $locationLogin, 1)
                    ),
                    array(
                        new KeyDescriptor(KeyDescriptor::USE_SIGNING, $certificate),
                        new KeyDescriptor(KeyDescriptor::USE_ENCRYPTION, $certificate)
                    )
                ),
                new IdpSsoDescriptor(
                    array(
                        new SingleLogoutService(Bindings::SAML2_HTTP_REDIRECT, $locationLogout),
                        new SingleLogoutService(Bindings::SAML2_HTTP_POST, $locationLogout),
                        new SingleSignOnService(Bindings::SAML2_HTTP_REDIRECT, $locationLogin),
                        new SingleSignOnService(Bindings::SAML2_HTTP_POST, $locationLogin)
                    ),
                    array(
                        new KeyDescriptor(KeyDescriptor::USE_SIGNING, $certificate),
                        new KeyDescriptor(KeyDescriptor::USE_ENCRYPTION, $certificate)
                    )
                )
            )
        );

        $context = new SerializationContext();
        $ed->getXml($context->getDocument(), $context);

        $xml = $context->getDocument()->saveXML();
        //print "\n $xml \n";


        $document = new \DOMDocument();
        $document->loadXML($xml);
        /** @var $root \DOMElement */
        $root = $document->firstChild;

        $this->checkXml($document, $entityID, $locationLogout, $locationLogin, $certificate);
        $this->checkDeserializaton($root, $entityID, $locationLogout, $locationLogin, $certificate);
    }


    private function checkXml(\DOMDocument $document, $entityID, $locationLogout, $locationLogin, X509Certificate $certificate) {
        /** @var $root \DOMElement */
        $root = $document->firstChild;
        $this->assertEquals(Protocol::NS_METADATA, $root->namespaceURI);
        $this->assertEquals('EntityDescriptor', $root->localName);
        $this->assertTrue($root->hasAttribute('entityID'));
        $this->assertEquals($entityID, $root->getAttribute('entityID'));

        $xpath = new \DOMXPath($document);
        $xpath->registerNamespace('md', Protocol::NS_METADATA);
        $xpath->registerNamespace('ds', Protocol::NS_XMLDSIG);


        // SP ------------------------------------------------

        $list = $xpath->query("/md:EntityDescriptor/md:SPSSODescriptor");
        $this->assertEquals(1, $list->length);
        /** @var $sp \DOMElement */
        $sp = $list->item(0);
        $this->assertEquals(Protocol::NS_METADATA, $sp->namespaceURI);
        $this->assertTrue($sp->hasAttribute('protocolSupportEnumeration'));
        $this->assertEquals(Protocol::SAML2, $sp->getAttribute('protocolSupportEnumeration'));


        $list = $xpath->query('/md:EntityDescriptor/md:SPSSODescriptor/md:KeyDescriptor');
        $this->assertEquals(2, $list->length);

        $list = $xpath->query('/md:EntityDescriptor/md:SPSSODescriptor/md:KeyDescriptor[@use="signing"]');
        $this->assertEquals(1, $list->length);

        $list = $xpath->query('/md:EntityDescriptor/md:SPSSODescriptor/md:KeyDescriptor[@use="encryption"]');
        $this->assertEquals(1, $list->length);

        $list = $xpath->query('/md:EntityDescriptor/md:SPSSODescriptor/md:KeyDescriptor[@use="signing"]/ds:KeyInfo/ds:X509Data');
        $this->assertEquals(1, $list->length);
        /** @var $key \DOMElement */
        $key = $list->item(0);
        $this->assertEquals($certificate->getData(), trim($key->nodeValue));

        $list = $xpath->query('/md:EntityDescriptor/md:SPSSODescriptor/md:KeyDescriptor[@use="encryption"]/ds:KeyInfo/ds:X509Data');
        $this->assertEquals(1, $list->length);
        /** @var $key \DOMElement */
        $key = $list->item(0);
        $this->assertEquals($certificate->getData(), trim($key->nodeValue));


        $list = $xpath->query('/md:EntityDescriptor/md:SPSSODescriptor/md:SingleLogoutService');
        $this->assertEquals(1, $list->length);
        $this->checkSpItemXml($list->item(0), 'SingleLogoutService', Bindings::SAML2_HTTP_REDIRECT, $locationLogout, null);

        $list = $xpath->query('/md:EntityDescriptor/md:SPSSODescriptor/md:AssertionConsumerService[@index="0"]');
        $this->assertEquals(1, $list->length);
        $this->checkSpItemXml($list->item(0), 'AssertionConsumerService', Bindings::SAML2_HTTP_POST, $locationLogin, 0);

        $list = $xpath->query('/md:EntityDescriptor/md:SPSSODescriptor/md:AssertionConsumerService[@index="1"]');
        $this->assertEquals(1, $list->length);
        $this->checkSpItemXml($list->item(0), 'AssertionConsumerService', Bindings::SAML2_HTTP_ARTIFACT, $locationLogin, 1);



        // IDP ---------------------------------------------------------

        $list = $xpath->query("/md:EntityDescriptor/md:IDPSSODescriptor");
        $this->assertEquals(1, $list->length);
        /** @var $idp \DOMElement */
        $idp = $list->item(0);
        $this->assertEquals(Protocol::NS_METADATA, $idp->namespaceURI);
        $this->assertTrue($idp->hasAttribute('protocolSupportEnumeration'));
        $this->assertEquals(Protocol::SAML2, $idp->getAttribute('protocolSupportEnumeration'));

        $list = $xpath->query('/md:EntityDescriptor/md:IDPSSODescriptor/md:KeyDescriptor');
        $this->assertEquals(2, $list->length);

        $list = $xpath->query('/md:EntityDescriptor/md:IDPSSODescriptor/md:KeyDescriptor[@use="signing"]');
        $this->assertEquals(1, $list->length);

        $list = $xpath->query('/md:EntityDescriptor/md:IDPSSODescriptor/md:KeyDescriptor[@use="encryption"]');
        $this->assertEquals(1, $list->length);

        $list = $xpath->query('/md:EntityDescriptor/md:IDPSSODescriptor/md:KeyDescriptor[@use="signing"]/ds:KeyInfo/ds:X509Data');
        $this->assertEquals(1, $list->length);
        /** @var $key \DOMElement */
        $key = $list->item(0);
        $this->assertEquals($certificate->getData(), trim($key->nodeValue));

        $list = $xpath->query('/md:EntityDescriptor/md:IDPSSODescriptor/md:KeyDescriptor[@use="encryption"]/ds:KeyInfo/ds:X509Data');
        $this->assertEquals(1, $list->length);
        /** @var $key \DOMElement */
        $key = $list->item(0);
        $this->assertEquals($certificate->getData(), trim($key->nodeValue));

        $list = $xpath->query('/md:EntityDescriptor/md:IDPSSODescriptor/md:SingleLogoutService');
        $this->assertEquals(2, $list->length);
        $this->checkSpItemXml($list->item(0), 'SingleLogoutService', Bindings::SAML2_HTTP_REDIRECT, $locationLogout, null);
        $this->checkSpItemXml($list->item(1), 'SingleLogoutService', Bindings::SAML2_HTTP_POST, $locationLogout, null);

        $list = $xpath->query('/md:EntityDescriptor/md:IDPSSODescriptor/md:SingleSignOnService');
        $this->assertEquals(2, $list->length);
        $this->checkSpItemXml($list->item(0), 'SingleSignOnService', Bindings::SAML2_HTTP_REDIRECT, $locationLogin, null);
        $this->checkSpItemXml($list->item(1), 'SingleSignOnService', Bindings::SAML2_HTTP_POST, $locationLogin, null);
    }


    private function checkSpItemXml(\DOMElement $element, $name, $binding, $location, $index) {
        $this->assertEquals(Protocol::NS_METADATA, $element->namespaceURI);
        $this->assertEquals($name, $element->localName);
        $this->assertTrue($element->hasAttribute('Binding'));
        $this->assertEquals($binding, $element->getAttribute('Binding'));
        $this->assertTrue($element->hasAttribute('Location'));
        $this->assertEquals($location, $element->getAttribute('Location'));
        if ($index !== null) {
            $this->assertTrue($element->hasAttribute('index'));
            $this->assertEquals($index, $element->getAttribute('index'));
        } else {
            $this->assertFalse($element->hasAttribute('index'));
        }
    }



    private function checkDeserializaton(\DOMElement $root, $entityID, $locationLogout, $locationLogin, X509Certificate $certificate) {
        $ed = new EntityDescriptor();
        $ed->loadFromXml($root);

        $this->assertEquals($entityID, $ed->getEntityID());

        $items = $ed->getItems();
        $this->assertEquals(2, count($items));
        $this->assertTrue($items[0] instanceof SpSsoDescriptor);

        $arrSP = $ed->getItemsByType('SpSsoDescriptor');
        $this->assertNotEmpty($arrSP);
        /** @var $sp SpSsoDescriptor */
        $sp = $arrSP[0];
        $this->assertNotNull($sp);
        $this->assertTrue($sp instanceof SpSsoDescriptor);

        $keys = $sp->getKeyDescriptors();
        $this->assertEquals(2, count($keys));
        $this->assertEquals(KeyDescriptor::USE_SIGNING, $keys[0]->getUse());
        $this->assertEquals($certificate->getData(), $keys[0]->getCertificate()->getData());
        $this->assertEquals(KeyDescriptor::USE_ENCRYPTION, $keys[1]->getUse());
        $this->assertEquals($certificate->getData(), $keys[1]->getCertificate()->getData());

        $this->assertEquals(Protocol::SAML2, $sp->getProtocolSupportEnumeration());

        $items = $sp->getServices();
        $this->assertEquals(3, count($items), print_r($items, true));

        $arrLogout = $sp->findSingleLogoutServices();
        $this->assertNotEmpty($arrLogout);
        $logout = $arrLogout[0];
        $this->assertNotNull($logout);
        $this->assertEquals(Bindings::SAML2_HTTP_REDIRECT, $logout->getBinding());
        $this->assertEquals($locationLogout, $logout->getLocation());

        $arr = $sp->findAssertionConsumerServices();
        $this->assertEquals(2, count($arr));

        $arr = $sp->findAssertionConsumerServices(Bindings::SAML2_HTTP_POST);
        $this->assertNotEmpty($arr);
        $as1 = $arr[0];
        $this->assertNotNull($as1);
        $this->assertEquals(Bindings::SAML2_HTTP_POST, $as1->getBinding());
        $this->assertEquals($locationLogin, $as1->getLocation());
        $this->assertEquals(0, $as1->getIndex());

        $arr = $sp->findAssertionConsumerServices(Bindings::SAML2_HTTP_ARTIFACT);
        $this->assertNotEmpty($arr);
        $as2 = $arr[0];
        $this->assertNotNull($as2);
        $this->assertEquals(Bindings::SAML2_HTTP_ARTIFACT, $as2->getBinding());
        $this->assertEquals($locationLogin, $as2->getLocation());
        $this->assertEquals(1, $as2->getIndex());

    }

}