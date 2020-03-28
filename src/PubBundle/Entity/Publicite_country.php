<?php

namespace PubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publicite_country
 *
 * @ORM\Table(name="publicite_country")
 * @ORM\Entity(repositoryClass="PubBundle\Repository\Publicite_countryRepository")
 */
class Publicite_country
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
     * @ORM\ManyToOne(targetEntity="Pub")
     * @ORM\JoinColumn(name="idPublicite", referencedColumnName="id")
     **/
    private $idPublicite;

    /**
     * @ORM\ManyToOne(targetEntity="Apps_countries")
     * @ORM\JoinColumn(name="idCountry", referencedColumnName="id")
     **/
    private $idCountry;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrClick", type="integer")
     */
    private $nbrClick;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idPublicite
     *
     * @param integer $idPublicite
     *
     * @return Publicite_country
     */
    public function setIdPublicite($idPublicite)
    {
        $this->idPublicite = $idPublicite;
    
        return $this;
    }

    /**
     * Get idPublicite
     *
     * @return integer
     */
    public function getIdPublicite()
    {
        return $this->idPublicite;
    }

    /**
     * Set idCountry
     *
     * @param integer $idCountry
     *
     * @return Publicite_country
     */
    public function setIdCountry($idCountry)
    {
        $this->idCountry = $idCountry;
    
        return $this;
    }

    /**
     * Get idCountry
     *
     * @return integer
     */
    public function getIdCountry()
    {
        return $this->idCountry;
    }

    /**
     * Set nbrClick
     *
     * @param integer $nbrClick
     *
     * @return Publicite_country
     */
    public function setNbrClick($nbrClick)
    {
        $this->nbrClick = $nbrClick;
    
        return $this;
    }

    /**
     * Get nbrClick
     *
     * @return integer
     */
    public function getNbrClick()
    {
        return $this->nbrClick;
    }
}

