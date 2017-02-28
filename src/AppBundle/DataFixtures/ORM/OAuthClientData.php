<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Client;

class OAuthClientData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $oauthClient = new Client();
        $oauthClient->setRandomId(base64_encode(random_bytes(15)));
        $oauthClient->setSecret(base64_encode(random_bytes(25)));
        $oauthClient->setAllowedGrantTypes(array('password'));

        $manager->persist($oauthClient);
        $manager->flush();
    }

}