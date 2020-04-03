<?php

namespace RestoDonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RepasServi
 *
 * @ORM\Table(name="repas_servi")
 * @ORM\Entity(repositoryClass="RestoDonBundle\Repository\RepasServiRepository")
 */
class RepasServi
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * Get idResto
     *
     * @return int
     */
    public function getIdResto()
    {
        return $this->idResto;
    }

    /**
     * Set idResto
     *
     * @param \Integer $idResto
     *
     * @return RepasServi
     */
    public function setIdResto($idResto)
    {
        $this->idResto = $idResto;

        return $this;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return RepasServi
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

