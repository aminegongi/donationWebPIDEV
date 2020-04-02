<?php

namespace CagnotteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * cagnotte
 *
 * @ORM\Table(name="cagnotte")
 * @ORM\Entity(repositoryClass="CagnotteBundle\Repository\cagnotteRepository")
 */
class cagnotte
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="CagnotteBundle\Entity\categoriecagnotte")
     *
     * @ORM\JoinColumn(name="id_categorie", referencedColumnName="id")
     */
    private $idCategorie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_creation", type="date")
     */
    private $dateDeCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_debut", type="date")
     */
    private $dateDeDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_de_fin", type="date")
     */
    private $dateDeFin;

    /**
     * @var float
     *
     * @ORM\Column(name="montant_demande", type="float")
     */
    private $montantDemande;

    /**
     * @var float
     *
     * @ORM\Column(name="montant_actuel", type="float")
     */
    private $montantActuel;

    /**
     * @var int
     *
     * @ORM\Column(name="id_proprietaire", type="integer")
     */
    private $idProprietaire;

    /**
     * @var int
     *
     * @ORM\Column(name="id_organisation", type="integer")
     */
    private $idOrganisation;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return cagnotte
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
     * Set idCategorie
     *
     * @param integer $idCategorie
     *
     * @return cagnotte
     */
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    
        return $this;
    }

    /**
     * Get idCategorie
     *
     * @return integer
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * Set dateDeCreation
     *
     * @param \DateTime $dateDeCreation
     *
     * @return cagnotte
     */
    public function setDateDeCreation($dateDeCreation)
    {
        $this->dateDeCreation = $dateDeCreation;
    
        return $this;
    }

    /**
     * Get dateDeCreation
     *
     * @return \DateTime
     */
    public function getDateDeCreation()
    {
        return $this->dateDeCreation;
    }

    /**
     * Set dateDeDebut
     *
     * @param \DateTime $dateDeDebut
     *
     * @return cagnotte
     */
    public function setDateDeDebut($dateDeDebut)
    {
        $this->dateDeDebut = $dateDeDebut;
    
        return $this;
    }

    /**
     * Get dateDeDebut
     *
     * @return \DateTime
     */
    public function getDateDeDebut()
    {
        return $this->dateDeDebut;
    }

    /**
     * Set dateDeFin
     *
     * @param \DateTime $dateDeFin
     *
     * @return cagnotte
     */
    public function setDateDeFin($dateDeFin)
    {
        $this->dateDeFin = $dateDeFin;
    
        return $this;
    }

    /**
     * Get dateDeFin
     *
     * @return \DateTime
     */
    public function getDateDeFin()
    {
        return $this->dateDeFin;
    }

    /**
     * Set montantDemande
     *
     * @param float $montantDemande
     *
     * @return cagnotte
     */
    public function setMontantDemande($montantDemande)
    {
        $this->montantDemande = $montantDemande;
    
        return $this;
    }

    /**
     * Get montantDemande
     *
     * @return float
     */
    public function getMontantDemande()
    {
        return $this->montantDemande;
    }

    /**
     * Set montantActuel
     *
     * @param float $montantActuel
     *
     * @return cagnotte
     */
    public function setMontantActuel($montantActuel)
    {
        $this->montantActuel = $montantActuel;
    
        return $this;
    }

    /**
     * Get montantActuel
     *
     * @return float
     */
    public function getMontantActuel()
    {
        return $this->montantActuel;
    }

    /**
     * Set idProprietaire
     *
     * @param integer $idProprietaire
     *
     * @return cagnotte
     */
    public function setIdProprietaire($idProprietaire)
    {
        $this->idProprietaire = $idProprietaire;
    
        return $this;
    }

    /**
     * Get idProprietaire
     *
     * @return integer
     */
    public function getIdProprietaire()
    {
        return $this->idProprietaire;
    }

    /**
     * Set idOrganisation
     *
     * @param integer $idOrganisation
     *
     * @return cagnotte
     */
    public function setIdOrganisation($idOrganisation)
    {
        $this->idOrganisation = $idOrganisation;
    
        return $this;
    }

    /**
     * Get idOrganisation
     *
     * @return integer
     */
    public function getIdOrganisation()
    {
        return $this->idOrganisation;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return cagnotte
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
}

