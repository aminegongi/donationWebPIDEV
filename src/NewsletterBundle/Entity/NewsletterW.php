<?php

namespace NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * NewsletterW
 *
 * @ORM\Table(name="newsletter_w")
 * @ORM\Entity(repositoryClass="NewsletterBundle\Repository\NewsletterWRepository")
 * @UniqueEntity("libelle")
 */
class NewsletterW
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="objetMail", type="string", length=255)
     */
    private $objetMail;

    /**
     * @ORM\ManyToOne(targetEntity="NewsHTMLBuilder")
     * @ORM\JoinColumn(name="corpsMailID", referencedColumnName="id" , onDelete="SET NULL")
     */
    private $corpsID;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnvoi", type="datetime", nullable=true)
     */
    private $dateEnvoi;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="addBy", referencedColumnName="id")
     */
    private $addBy;

    /**
     * @var string
     *
     * @ORM\Column(name="dateAjout", type="datetime")
     */
    private $dateAjout;


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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return NewsletterW
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set objetMail
     *
     * @param string $objetMail
     *
     * @return NewsletterW
     */
    public function setObjetMail($objetMail)
    {
        $this->objetMail = $objetMail;

        return $this;
    }

    /**
     * Get objetMail
     *
     * @return string
     */
    public function getObjetMail()
    {
        return $this->objetMail;
    }

    /**
     * Set dateEnvoi
     *
     * @param \DateTime $dateEnvoi
     *
     * @return NewsletterW
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi
     *
     * @return \DateTime
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }



    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return NewsletterW
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set corpsID
     *
     * @param \NewsletterBundle\Entity\NewsHTMLBuilder $corpsID
     *
     * @return NewsletterW
     */
    public function setCorpsID(\NewsletterBundle\Entity\NewsHTMLBuilder $corpsID = null)
    {
        $this->corpsID = $corpsID;

        return $this;
    }

    /**
     * Get corpsID
     *
     * @return \NewsletterBundle\Entity\NewsHTMLBuilder
     */
    public function getCorpsID()
    {
        return $this->corpsID;
    }

    /**
     * Set addBy
     *
     * @param \UserBundle\Entity\User $addBy
     *
     * @return NewsletterW
     */
    public function setAddBy(\UserBundle\Entity\User $addBy = null)
    {
        $this->addBy = $addBy;

        return $this;
    }

    /**
     * Get addBy
     *
     * @return \UserBundle\Entity\User
     */
    public function getAddBy()
    {
        return $this->addBy;
    }
}
