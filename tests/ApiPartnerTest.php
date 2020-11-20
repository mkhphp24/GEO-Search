<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Partner;

class ApiPartnerTest extends WebTestCase
{
    protected $client;
    private $em;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGetcordinate()
    {
        $partner=new Partner();
        $partner->setLat('50.0000');
        $partner->setLng('6.0000');
        $partner->setName('test');
        $partner->setThoroughfare('test');

        $this->em->persist($partner);
        $this->em->flush();

        $this->client->request('POST', '/api/cordinate/',[
            'form-distance-lat'=>'50.0000',
            'form-distance-lng'=>'6.0000',
            'form-distance-km'=>'1',
        ]);


        $content='{
          "type": "FeatureCollection",
          "features": [
           
                {
                  "type": "Feature",
                  "properties": {"style":"point","name":"test","thoroughfare":"test","distance":"0"},
                  "geometry": {
                    "type": "Point",
                    "coordinates": [
                        6.000000,
                        50.000000
                    ]
                  }
                },
                {
                  "type": "Feature",
                  "properties": {"style":"point_center"},
                  "geometry": {
                    "type": "Point",
                    "coordinates": [
                        6.0000,
                        50.0000
                    ]
                  }
                }
          ]
        }';

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($content, $response->getContent());

        $this->client->request('POST', '/api/cordinate/',[
            'form-distance-lat'=>'d0',
            'form-distance-lng'=>'r',
            'form-distance-km'=>'g',
        ]);
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());

        $partnerTest=$this->em->getRepository(Partner::class)->findOneBy(['name' => 'test']);
        $this->em->remove($partnerTest);
        $this->em->flush();

    }

    public function testGetPostcode()
    {
        $response = $this->client->request('GET', '/api/search/postcod/1/?q[term]=10115&q[_type]=query&page_limit=10');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }

}


