<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Client
 *
 * @ORM\Table(name="partners")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Partner implements LocationInterface
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=190)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $thoroughfare;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $premise;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\PostalCodeLocation")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=190, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\Column(type="array", nullable=true)
     * @Assert\All({
     *     @Assert\NotBlank(),
     *     @Assert\Url(protocols={"http","https"}, checkDNS=true)
     * })
     */
    private $websites;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal",precision=9,scale=6,nullable=true)
     * @Assert\Range(min=-90, max=90)
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal",precision=9,scale=6,nullable=true)
     * @Assert\Range(min=-180, max=180)
     */
    private $lng;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8, nullable=true)
     * @Assert\Locale()
     */
    private $locale;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->websites = [];
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Partner
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set thoroughfare
     *
     * @param string $thoroughfare
     *
     * @return Partner
     */
    public function setThoroughfare(string $thoroughfare)
    {
        $this->thoroughfare = $thoroughfare;

        return $this;
    }

    /**
     * Get thoroughfare
     *
     * @return string
     */
    public function getThoroughfare()
    {
        return $this->thoroughfare;
    }

    /**
     * Set premise
     *
     * @param string $premise
     *
     * @return Partner
     */
    public function setPremise(string $premise)
    {
        $this->premise = $premise;

        return $this;
    }

    /**
     * Get premise
     *
     * @return string
     */
    public function getPremise()
    {
        return $this->premise;
    }

    /**
     * Set postalCode
     *
     * @param  $postalCode
     *
     * @return Partner
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Partner
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set websites
     *
     * @param array $websites
     * @return Partner
     */
    public function setWebsites(array $websites)
    {
        $this->websites = $websites;

        return $this;
    }

    /**
     * Get websites
     *
     * @return array
     */
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @param string $website
     * @return Partner $this
     */
    public function addWebsite(string $website)
    {
        $this->websites[] = $website;
        return $this;
    }

    /**
     * @param string $website
     * @return Partner
     */
    public function removeWebsite(string $website)
    {
        if (in_array($website, $this->websites)) {
            unset($this->websites[array_search($website, $this->websites)]);
        }
        return $this;
    }

    /**
     * Set latitude
     *
     * @param float $lat
     *
     * @return Partner
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set longitude
     *
     * @param float $lng
     *
     * @return Partner
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     * @return Partner
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }
}
