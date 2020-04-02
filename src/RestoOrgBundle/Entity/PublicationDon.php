<?php

namespace RestoOrgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PublicationDon
 *
 * @ORM\Table(name="publicationdon")
 * @ORM\Entity(repositoryClass="RestoOrgBundle\Repository\PublicationDonRepository")
 */
class PublicationDon
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
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="datetime", options={"default": "CURRENT_TIMESTAMP"} ,nullable=true )
     */
    private $datePublication;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreUp", type="integer", nullable=true)
     */
    private $nbreUp;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrePlat", type="integer", nullable=true)
     */
    private $nbrePlat;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer",options={"default": 1},nullable=true)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="ajoutePar", referencedColumnName="id")
     **/
    private $ajoutePar;

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
     * Set type
     *
     * @param string $type
     *
     * @return PublicationDon
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return PublicationDon
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PublicationDon
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return PublicationDon
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;
    
        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set nbreUp
     *
     * @param integer $nbreUp
     *
     * @return PublicationDon
     */
    public function setNbreUp($nbreUp)
    {
        $this->nbreUp = $nbreUp;
    
        return $this;
    }

    /**
     * Get nbreUp
     *
     * @return integer
     */
    public function getNbreUp()
    {
        return $this->nbreUp;
    }

    /**
     * Set nbrePlat
     *
     * @param integer $nbrePlat
     *
     * @return PublicationDon
     */
    public function setNbrePlat($nbrePlat)
    {
        $this->nbrePlat = $nbrePlat;
    
        return $this;
    }

    /**
     * Get nbrePlat
     *
     * @return integer
     */
    public function getNbrePlat()
    {
        return $this->nbrePlat;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return PublicationDon
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    
        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @return mixed
     */
    public function getAjoutePar()
    {
        return $this->ajoutePar;
    }

    /**
     * @param mixed $ajoutePar
     */
    public function setAjoutePar($ajoutePar)
    {
        $this->ajoutePar = $ajoutePar;
    }




}

