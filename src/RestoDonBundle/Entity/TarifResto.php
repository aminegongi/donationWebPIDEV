<?php

namespace RestoDonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TarifResto
 *
 * @ORM\Table(name="tarif_resto")
 * @ORM\Entity(repositoryClass="RestoDonBundle\Repository\TarifRestoRepository")
 */
class TarifResto
{
    /**
     * @var int
     *
     * @ORM\Column(name="idResto", type="integer")
     * @ORM\Id
     *
     */
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
     * @ORM\Column(name="portefeuille_virtuel", type="decimal", precision=9, scale=3, nullable=true)
     */
    private $portefeuilleVirtuel;


    /**
     * Get id
     *
     * @return int
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

