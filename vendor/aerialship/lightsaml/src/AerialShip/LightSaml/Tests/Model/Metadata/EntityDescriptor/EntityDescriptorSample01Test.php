<?php

namespace AerialShip\LightSaml\Tests\Model\Metadata\EntityDescriptor;

use AerialShip\LightSaml\Bindings;
use AerialShip\LightSaml\Model\Metadata\EntityDescriptor;
use AerialShip\LightSaml\Model\Metadata\KeyDescriptor;


class EntityDescriptorSample01Test extends \PHPUnit_Framework_TestCase
{

    function testOne() {
        $url = "https://b1.bead.loc/adfs/ls/";

        $doc = new \DOMDocument();
        $doc->load(__DIR__.'/../../../../../../../resources/sample/EntityDescriptor/idp2-ed.xml');

        $ed = new EntityDescriptor();
        $ed->loadFromXml($doc->firstChild);

        $this->checkSP($ed, $url);
        $this->checkIDP($ed, $url);
    }

    private function checkIDP(EntityDescriptor $ed, $url) {
        $arr = $ed->getAllIdpSsoDescriptors();
        $this->assertEquals(1, count($arr));
        $idp = $arr[0];

        $this->assertEquals(2, count($idp->getKeyDescriptors()));

        $arr = $idp->findKeyDescriptors(KeyDescriptor::USE_SIGNING);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(KeyDescriptor::USE_SIGNING, $arr[0]->getUse());
        $cert = $arr[0]->getCertificate();
        $this->assertNotNull($cert);
        $this->assertGreaterThan(100, strlen($cert->getData()));

        $arr = $idp->findKeyDescriptors(KeyDescriptor::USE_ENCRYPTION);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(KeyDescriptor::USE_ENCRYPTION, $arr[0]->getUse());
        $cert = $arr[0]->getCertificate();
        $this->assertNotNull($cert);
        $this->assertGreaterThan(100, strlen($cert->getData()));

        $this->assertEquals(2, count($idp->findSingleLogoutServices()));

        $arr = $idp->findSingleLogoutServices(Bindings::SAML2_HTTP_REDIRECT);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(Bindings::SAML2_HTTP_REDIRECT, $arr[0]->getBinding());
        $this->assertEquals($url, $arr[0]->getLocation());

        $arr = $idp->findSingleLogoutServices(Bindings::SAML2_HTTP_POST);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(Bindings::SAML2_HTTP_POST, $arr[0]->getBinding());
        $this->assertEquals($url, $arr[0]->getLocation());

        $this->assertEquals(2, count($idp->findSingleSignOnServices()));

        $arr = $idp->findSingleLogoutServices(Bindings::SAML2_HTTP_POST);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(Bindings::SAML2_HTTP_POST, $arr[0]->getBinding());
        $this->assertEquals($url, $arr[0]->getLocation());

        $arr = $idp->findSingleLogoutServices(Bindings::SAML2_HTTP_REDIRECT);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(Bindings::SAML2_HTTP_REDIRECT, $arr[0]->getBinding());
        $this->assertEquals($url, $arr[0]->getLocation());
    }

    private function checkSP(EntityDescriptor $ed, $url) {
        $arr = $ed->getAllSpSsoDescriptors();
        $this->assertEquals(1, count($arr));
        $sp = $arr[0];

        $this->assertTrue($sp->getWantAssertionsSigned());
        $this->assertEquals(2, count($sp->getKeyDescriptors()));

        $arr = $sp->findKeyDescriptors(KeyDescriptor::USE_SIGNING);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(KeyDescriptor::USE_SIGNING, $arr[0]->getUse());
        $cert = $arr[0]->getCertificate();
        $this->assertNotNull($cert);
        $this->assertGreaterThan(100, strlen($cert->getData()));

        $arr = $sp->findKeyDescriptors(KeyDescriptor::USE_ENCRYPTION);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(KeyDescriptor::USE_ENCRYPTION, $arr[0]->getUse());
        $cert = $arr[0]->getCertificate();
        $this->assertNotNull($cert);
        $this->assertGreaterThan(100, strlen($cert->getData()));


        $this->assertEquals(2, count($sp->findSingleLogoutServices()));

        $arr = $sp->findSingleLogoutServices(Bindings::SAML2_HTTP_REDIRECT);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(Bindings::SAML2_HTTP_REDIRECT, $arr[0]->getBinding());
        $this->assertEquals($url, $arr[0]->getLocation());

        $arr = $sp->findSingleLogoutServices(Bindings::SAML2_HTTP_POST);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(Bindings::SAML2_HTTP_POST, $arr[0]->getBinding());
        $this->assertEquals($url, $arr[0]->getLocation());


        $this->assertEquals(3, count($sp->findAssertionConsumerServices()));

        $arr = $sp->findAssertionConsumerServices(Bindings::SAML2_HTTP_POST);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(Bindings::SAML2_HTTP_POST, $arr[0]->getBinding());
        $this->assertEquals($url, $arr[0]->getLocation());
        $this->assertEquals(0, $arr[0]->getIndex());

        $arr = $sp->findAssertionConsumerServices(Bindings::SAML2_HTTP_ARTIFACT);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(Bindings::SAML2_HTTP_ARTIFACT, $arr[0]->getBinding());
        $this->assertEquals($url, $arr[0]->getLocation());
        $this->assertEquals(1, $arr[0]->getIndex());

        $arr = $sp->findAssertionConsumerServices(Bindings::SAML2_HTTP_REDIRECT);
        $this->assertEquals(1, count($arr));
        $this->assertEquals(Bindings::SAML2_HTTP_REDIRECT, $arr[0]->getBinding());
        $this->assertEquals($url, $arr[0]->getLocation());
        $this->assertEquals(2, $arr[0]->getIndex());
    }
}