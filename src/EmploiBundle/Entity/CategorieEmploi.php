<?php

namespace EmploiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategorieEmploi
 *
 * @ORM\Table(name="categorie_emploi")
 * @ORM\Entity(repositoryClass="EmploiBundle\Repository\CategorieEmploiRepository")
 */
class CategorieEmploi
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
     * @ORM\Column(name="titre_categorie", type="string", length=255)
     */
    private $titreCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="description_categorie", type="string", length=255)
     */
    private $descriptionCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;




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
     * Set titreCategorie
     *
     * @param string $titreCategorie
     *
     * @return CategorieEmploi
     */
    public function setTitreCategorie($titreCategorie)
    {
        $this->titreCategorie = $titreCategorie;

        return $this;
    }

    /**
     * Get titreCategorie
     *
     * @return string
     */
    public function getTitreCategorie()
    {
        return $this->titreCategorie;
    }

    /**
     * Set descriptionCategorie
     *
     * @param string $descriptionCategorie
     *
     * @return CategorieEmploi
     */
    public function setDescriptionCategorie($descriptionCategorie)
    {
        $this->descriptionCategorie = $descriptionCategorie;

        return $this;
    }

    /**
     * Get descriptionCategorie
     *
     * @return string
     */
    public function getDescriptionCategorie()
    {
        return $this->descriptionCategorie;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return CategorieEmploi
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
