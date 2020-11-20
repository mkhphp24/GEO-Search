<?php

namespace App\Tests;

use App\Services\GeoJsonService;
use PHPUnit\Framework\TestCase;

class GeoJsonTest extends TestCase
{

    public function testMakePoint()
    {

        $geoJsonService=new GeoJsonService([]);
        $geojson=$geoJsonService->makePoint('50.0000' , '6.0000');

        $contentTest ='{
          "type": "FeatureCollection",
          "features": [
           
                {
                  "type": "Feature",
                  "properties": {"style":"point_center"},
                  "geometry": {
                    "type": "Point",
                    "coordinates": [
                        50.0000,
                        6.0000
                    ]
                  }
                }
          ]
        }';

        $this->assertEquals($contentTest,$geojson);


    }


}
