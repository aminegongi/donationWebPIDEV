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
     * @ORM\Column(name="idRepas", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $idRepas;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idResto", referencedColumnName="id")
     **/
    private $idResto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="tarif", type="decimal", precision=9, scale=3)
     */
    private $tarif;



    /**
     * @return int
     */
    public function getIdRepas()
    {
        return $this->idRepas;
    }




    /**
     * @return mixed
     */
    public function getIdResto()
    {
        return $this->idResto;
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
     * Set date
     *
     * @param \DateTime $date
     *
     */
    public function setDate($date)
    {
        $this->date = $date;

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

    /**
     * * Get tarif
     *
     * @return string
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * * Set date
     *
     * @param string $tarif
     *
     * * @return RepasServi
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;

        return $this;
    }
}

