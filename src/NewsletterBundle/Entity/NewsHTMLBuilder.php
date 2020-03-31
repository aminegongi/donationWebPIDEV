<?php

namespace NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * NewsHTMLBuilder
 *
 * @ORM\Table(name="news_h_t_m_l_builder")
 * @ORM\Entity(repositoryClass="NewsletterBundle\Repository\NewsHTMLBuilderRepository")
 */
class NewsHTMLBuilder
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="corpsHTML", type="text")
     */
    private $corpsHTML;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjout", type="datetime",nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateAjout;

    /**
    * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
    * @ORM\JoinColumn(name="addBy", referencedColumnName="id")
    */
    private $addBy;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return NewsHTMLBuilder
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
     * Set corpsHTML
     *
     * @param string $corpsHTML
     *
     * @return NewsHTMLBuilder
     */
    public function setCorpsHTML($corpsHTML)
    {
        $this->corpsHTML = $corpsHTML;

        return $this;
    }

    /**
     * Get corpsHTML
     *
     * @return string
     */
    public function getCorpsHTML()
    {
        return $this->corpsHTML;
    }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return NewsHTMLBuilder
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
     * Set addBy
     *
     * @param \UserBundle\Entity\User $addBy
     *
     * @return NewsHTMLBuilder
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
