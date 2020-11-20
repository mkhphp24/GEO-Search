<?php

namespace App\Services;

class GeoJsonService
{
        private $points;

        /**
         * MakeGeoJason constructor.
         * @param $points
         */
        public function __construct($points)
        {
            $this->points = $points;
        }

        /**
         * @param string $lat
         * @param string $lng
         * @return string
         */
        public function makePoint(string $lat,string $lng):string
        {

            $result = '{
              "type": "FeatureCollection",
              "features": [
               ';

            foreach ($this->points as $point) {

                $result .= '
                    {
                      "type": "Feature",
                      "properties": {"style":"point","name":"'.$point['name'].'","thoroughfare":"'.$point['thoroughfare'].'","distance":"'.$point['distance'].'"},
                      "geometry": {
                        "type": "Point",
                        "coordinates": [
                            '.$point['lng'].',
                            '.$point['lat'].'
                        ]
                      }
                    },';

            }$result .= '
                    {
                      "type": "Feature",
                      "properties": {"style":"point_center"},
                      "geometry": {
                        "type": "Point",
                        "coordinates": [
                            '.$lat.',
                            '.$lng.'
                        ]
                      }
                    }
              ]
            }';
            return $result;
        }
}
