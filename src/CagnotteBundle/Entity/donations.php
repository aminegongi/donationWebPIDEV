<?php

namespace CagnotteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * donations
 *
 * @ORM\Table(name="donations")
 * @ORM\Entity(repositoryClass="CagnotteBundle\Repository\donationsRepository")
 */
class donations
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
     * @ORM\ManyToOne(targetEntity="CagnotteBundle\Entity\cagnotte")
     *
     * @ORM\JoinColumn(name="id_cagnotte", referencedColumnName="id")
     */
    private $idCagnotte;

    /**
     * @var int
     *
     * @ORM\Column(name="id_utilisateur", type="integer")
     */
    private $idUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_don", type="date")
     */
    private $dateDon;

    /**
     * @var string
     *
     * @ORM\Column(name="methode", type="string", length=255)
     */
    private $methode;


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
     * Set idCagnotte
     *
     * @param integer $idCagnotte
     *
     * @return donations
     */
    public function setIdCagnotte($idCagnotte)
    {
        $this->idCagnotte = $idCagnotte;
    
        return $this;
    }

    /**
     * Get idCagnotte
     *
     * @return integer
     */
    public function getIdCagnotte()
    {
        return $this->idCagnotte;
    }

    /**
     * Set idUtilisateur
     *
     * @param integer $idUtilisateur
     *
     * @return donations
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;
    
        return $this;
    }

    /**
     * Get idUtilisateur
     *
     * @return integer
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return donations
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return donations
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    
        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set dateDon
     *
     * @param \DateTime $dateDon
     *
     * @return donations
     */
    public function setDateDon($dateDon)
    {
        $this->dateDon = $dateDon;
    
        return $this;
    }

    /**
     * Get dateDon
     *
     * @return \DateTime
     */
    public function getDateDon()
    {
        return $this->dateDon;
    }

    /**
     * Set methode
     *
     * @param string $methode
     *
     * @return donations
     */
    public function setMethode($methode)
    {
        $this->methode = $methode;
    
        return $this;
    }

    /**
     * Get methode
     *
     * @return string
     */
    public function getMethode()
    {
        return $this->methode;
    }
}

