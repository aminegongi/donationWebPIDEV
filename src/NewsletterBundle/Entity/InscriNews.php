<?php

namespace NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscriNews
 *
 * @ORM\Table(name="inscri_news")
 * @ORM\Entity(repositoryClass="NewsletterBundle\Repository\InscriNewsRepository")
 */
class InscriNews
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
     * @ORM\Column(name="a_mail", type="string", length=255)
     */
    private $aMail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateInscri", type="datetime", nullable=true , options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateInscri;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="a_ip", type="string", length=255)
     */
    private $ip;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set aMail
     *
     * @param string $aMail
     *
     * @return InscriNews
     */
    public function setAMail($aMail)
    {
        $this->aMail = $aMail;

        return $this;
    }

    /**
     * Get aMail
     *
     * @return string
     */
    public function getAMail()
    {
        return $this->aMail;
    }

    /**
     * Set dateInscri
     *
     * @param \DateTime $dateInscri
     *
     * @return InscriNews
     */
    public function setDateInscri($dateInscri)
    {
        $this->dateInscri = $dateInscri;

        return $this;
    }

    /**
     * Get dateInscri
     *
     * @return \DateTime
     */
    public function getDateInscri()
    {
        return $this->dateInscri;
    }


    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return InscriNews
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return InscriNews
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }
}
