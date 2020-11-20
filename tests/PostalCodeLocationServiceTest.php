<?php

namespace App\Tests;

use App\Entity\PostalCodeLocation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Services\PostalCodeLocationService;

class PostalCodeLocationServiceTest extends WebTestCase
{
    protected $client;
    private $em;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testPostalCodeLocationSearchfield(){

        $sql="INSERT INTO `postal_codes` (`country`, `postal_code`, `lat`, `lng`, `name`, `updated_at`, `created_at`) 
                                  VALUES ('DE', '000000000', '50.0000', '6.0000', 'test', '2020-11-20 00:00:00', '2020-11-20 00:00:00')";

        $stmt = $this->em->getConnection()->prepare($sql);
        $stmt->execute();
        $id = $this->em->getConnection()->lastInsertId();

        $objectPostalCodeLocation = new PostalCodeLocationService( $this->em , PostalCodeLocation::class);
        $result=$objectPostalCodeLocation->PostalCodeLocationSearchfield('postalCode', '000000000','1');

        $arrayTest=array (
            0 =>
                array (
                    'id' => $id,
                    'lat' => '50.000000',
                    'lng' => '6.000000',
                    'text' => 'test 000000000'
                )
        );

        $this->assertEquals($arrayTest, $result);

        $partnerTest=$this->em->getRepository(PostalCodeLocation::class)->findOneBy(['id' => $id]);
        $this->em->remove($partnerTest);
        $this->em->flush();

    }
}
