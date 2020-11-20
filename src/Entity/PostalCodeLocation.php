<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PostalCodeLocation
 *
 * @ORM\Table(name="postal_codes", indexes={
 *     @ORM\Index(name="country", columns={"country"}),
 *     @ORM\Index(name="language", columns={"language"}),
 *     @ORM\Index(name="postal_code", columns={"postal_code"})
 * })
 * @ORM\Entity()
 */
class PostalCodeLocation implements LocationInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=2,nullable=false)
     * @Assert\NotBlank
     * @Assert\Country()
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=20,nullable=false)
     * @Assert\NotBlank
     */
    protected $postalCode;

    /**
     * @var double
     *
     * @ORM\Column(type="decimal",precision=9,scale=6,nullable=false)
     * @Assert\NotBlank
     */
    protected $lat;

    /**
     * @var double
     *
     * @ORM\Column(type="decimal",precision=9,scale=6,nullable=false)
     * @Assert\NotBlank
     */
    protected $lng;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $stateCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $province;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $provinceCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $community;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $communityCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5, nullable=true)
     * @Assert\Locale()
     */
    private $language;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PostalCodeLocation
     */
    public function setName(string $name): PostalCodeLocation
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return PostalCodeLocation
     */
    public function setState(string $state): PostalCodeLocation
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getStateCode(): string
    {
        return $this->stateCode;
    }

    /**
     * @param string $stateCode
     * @return PostalCodeLocation
     */
    public function setStateCode(string $stateCode): PostalCodeLocation
    {
        $this->stateCode = $stateCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvince(): string
    {
        return $this->province;
    }

    /**
     * @param string $province
     * @return PostalCodeLocation
     */
    public function setProvince(string $province): PostalCodeLocation
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvinceCode(): string
    {
        return $this->provinceCode;
    }

    /**
     * @param string $provinceCode
     * @return PostalCodeLocation
     */
    public function setProvinceCode(string $provinceCode): PostalCodeLocation
    {
        $this->provinceCode = $provinceCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommunity(): string
    {
        return $this->community;
    }

    /**
     * @param string $community
     * @return PostalCodeLocation
     */
    public function setCommunity(string $community): PostalCodeLocation
    {
        $this->community = $community;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommunityCode(): string
    {
        return $this->communityCode;
    }

    /**
     * @param string $communityCode
     * @return PostalCodeLocation
     */
    public function setCommunityCode(string $communityCode): PostalCodeLocation
    {
        $this->communityCode = $communityCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return PostalCodeLocation
     */
    public function setLanguage(string $language): PostalCodeLocation
    {
        $this->language = $language;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function setLat($lat) {
        $this->lat = $lat;
    }

    public function getLat() {
        return $this->lat;
    }

    public function setLng($lng) {
        $this->lng = $lng;
    }

    public function getLng() {
        return $this->lng;
    }

    function __toString()
    {
        return $this->country.'-'.$this->postalCode.' '.$this->name;
    }
}
