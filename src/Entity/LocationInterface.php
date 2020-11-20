<?php

namespace App\Entity;

interface LocationInterface
{
    public function setLat($lat);

    public function getLat();

    public function setLng($lng);

    public function getLng();
}
