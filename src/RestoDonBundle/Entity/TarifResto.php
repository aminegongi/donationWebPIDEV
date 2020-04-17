<?php

namespace RestoDonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TarifResto
 *
 * @ORM\Table(name="tarif_resto")
 * @ORM\Entity(repositoryClass="RestoDonBundle\Repository\TarifRestoRepository")
 * @UniqueEntity(fields="idResto", message="Ce resto possède déjà un tarif.")
 */
class TarifResto
{
    /**
     * @var int
     *
     * @ORM\Column(name="idTarif", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idTarif;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idResto", referencedColumnName="id", unique=true, nullable=false)
     **/
    private $idResto;

    /**
     * @var string
     *
     * @ORM\Column(name="tarif", type="decimal", precision=9, scale=3)
     */
    private $tarif;

    /**
     * @var string
     *
     * @ORM\Column(name="portefeuille_virtuel", type="decimal", precision=9, scale=3, options={"default" : 0})
     */
    private $portefeuilleVirtuel= 0.000;


    /**
     * Get idTarif
     *
     * @return int
     */
    public function getIdTarif()
    {
        return $this->idTarif;
    }

    /**
     * @param mixed $idResto
     */
    public function setIdResto($idResto)
    {
        $this->idResto = $idResto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdResto()
    {
        return $this->idResto;
    }

    /**
     * Set tarif
     *
     * @param string $tarif
     *
     * @return TarifResto
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }

    /**
     * Get tarif
     *
     * @return string
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * Set portefeuilleVirtuel
     *
     * @param string $portefeuilleVirtuel
     *
     * @return TarifResto
     */
    public function setPortefeuilleVirtuel($portefeuilleVirtuel)
    {
        $this->portefeuilleVirtuel = $portefeuilleVirtuel;

        return $this;
    }

    /**
     * Get portefeuilleVirtuel
     *
     * @return string
     */
    public function getPortefeuilleVirtuel()
    {
        return $this->portefeuilleVirtuel;
    }
}

