<?php

namespace App\Tests;

use App\Entity\Partner;
use App\Services\PartnerService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartnerServiceTest  extends WebTestCase
{
    protected $client;
    private $em;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testDistance(){

        $partner=new Partner();
        $partner->setLat('50.0000');
        $partner->setLng('6.0000');
        $partner->setName('test');
        $partner->setThoroughfare('test');

        $this->em->persist($partner);
        $this->em->flush();

        $objectPartnerService = new PartnerService( $this->em, Partner::class);
        $points=$objectPartnerService->findDistance( '50.0000' , '6.0000' , '1');

        $arrayTest=array (
            0 =>
                array (
                    'name' => 'test',
                    'thoroughfare' => 'test',
                    'lat' => '50.000000',
                    'lng' => '6.000000',
                    'distance' => '0'
                )
        );

        $this->assertEquals($arrayTest, $points);


        $partnerTest=$this->em->getRepository(Partner::class)->findOneBy(['name' => 'test']);
        $this->em->remove($partnerTest);
        $this->em->flush();

        $points=$objectPartnerService->findDistance( '50.0000' , '6.0000' , '1');
        $arrayTest=array ();
        $this->assertEquals($arrayTest, $points);

    }
}
