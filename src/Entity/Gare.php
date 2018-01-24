<?php
/**
 * Created by PhpStorm.
 * User: Sylva
 * Date: 22/01/2018
 * Time: 21:30
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class Gare
 *
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\GareRepository")
 */
class Gare
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column
     */
    private $realName;


    /**
     * @var string
     * @ORM\Column
     */
    private $arret;

    /**
     * @var string
     * @ORM\Column
     */
    private $zone;

    /**
     * @var string
     * @ORM\Column
     */
    private $uic;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Gare
     */
    public function setId(int $id): Gare
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return Gare
     */
    public function setSlug(string $slug): Gare
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getRealName(): string
    {
        return $this->realName;
    }

    /**
     * @param string $realName
     *
     * @return Gare
     */
    public function setRealName(string $realName): Gare
    {
        $this->realName = $realName;
        return $this;
    }

    /**
     * @return string
     */
    public function getUic(): string
    {
        return $this->uic;
    }

    /**
     * @param string $uic
     *
     * @return Gare
     */
    public function setUic(string $uic): Gare
    {
        $this->uic = $uic;
        return $this;
    }

    /**
     * @return string
     */
    public function getArret(): string
    {
        return $this->arret;
    }

    /**
     * @param string $arret
     */
    public function setArret(string $arret): void
    {
        $this->arret = $arret;
    }

    /**
     * @return string
     */
    public function getZone(): string
    {
        return $this->zone;
    }

    /**
     * @param string $zone
     */
    public function setZone(string $zone): void
    {
        $this->zone = $zone;
    }


}