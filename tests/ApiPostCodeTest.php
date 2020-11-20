<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\PostalCodeLocation;

class ApiPostCodeTest extends WebTestCase
{
    protected $client;
    private $em;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testGetPostcode()
    {
        $sql="INSERT INTO `postal_codes` (`country`, `postal_code`, `lat`, `lng`, `name`, `updated_at`, `created_at`) 
                                  VALUES ('DE', '000000000', '50.0000', '6.0000', 'test', '2020-11-20 00:00:00', '2020-11-20 00:00:00')";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $id = $this->em->getConnection()->lastInsertId();
        $this->client->request('GET', '/api/search/postcod/1/?q[term]=000000000&q[_type]=query&page_limit=10');

        $content='{"total_count":1,"incomplete_results":false,"items":[{"id":'.$id.',"lat":"50.000000","lng":"6.000000","text":"test 000000000"}]}';

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($content, $response->getContent());

        $this->client->request('GET', '/api/search/postcod/1/?q[term]=test&q[_type]=query&page_limit=10');

        $response = $this->client->getResponse();
                $this->assertEquals(400, $response->getStatusCode());

       $partnerTest=$this->em->getRepository(PostalCodeLocation::class)->findOneBy(['id' => $id]);
       $this->em->remove($partnerTest);
       $this->em->flush();

    }


}


