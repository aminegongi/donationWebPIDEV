<?php

namespace UserBundle\Entity;
use Doctrine\ORM\Query\Expr\Base;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="nom", nullable=true ,type="string",length=255)
     */
    private $nom;

    /**
     * @ORM\Column(name="numTel", type="string",length=255)
     */
    private $numTel;

    /**
     * @ORM\Column(name="pays",nullable=true , type="string",length=255)
     */
    private $pays;

    /**
     * @ORM\Column(name="ville",nullable=true , type="string",length=255)
     */
    private $ville;

    /**
     * @ORM\Column(name="image",nullable=true , type="string",length=255)
     */
    private $image="user.png";

    /**
     * @ORM\Column(name="pointXP",nullable=true , type="integer")
     */
    private $pointXP;

    // US
    /**
     * @ORM\Column(name="prenom",nullable=true, type="string",length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(name="genre",nullable=true, type="string",length=255)
     */
    private $genre;

    /**
     * @ORM\Column(name="dateNaissance",nullable=true, type="datetime")
     */
    private $dateNaissance;

    //ORG ENT RES
    /**
     * @ORM\Column(name="pageFB",nullable=true, type="string",length=255)
     */
    private $pageFB;

    /**
     * @ORM\Column(name="siteWeb",nullable=true, type="string",length=255)
     */
    private $siteWeb;

    /**
     * @ORM\Column(name="description",nullable=true, type="text")
     */
    private $description;

    /**
     * @ORM\Column(name="longitude",nullable=true, type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(name="latitude",nullable=true, type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(name="yesNews",type="integer" )
     */
    private $yesNews=0;


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
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getNumTel()
    {
        return $this->numTel;
    }

    /**
     * @param mixed $numTel
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param mixed $dateNaissance
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param mixed $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getPointXP()
    {
        return $this->pointXP;
    }

    /**
     * @param mixed $pointXP
     */
    public function setPointXP($pointXP)
    {
        $this->pointXP = $pointXP;
    }

    /**
     * @return mixed
     */
    public function getPageFB()
    {
        return $this->pageFB;
    }

    /**
     * @param mixed $pageFB
     */
    public function setPageFB($pageFB)
    {
        $this->pageFB = $pageFB;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * @param mixed $siteWeb
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;
    }

    /**
     * @return mixed
     */
    public function getYesNews()
    {
        return $this->yesNews;
    }

    /**
     * @param mixed $yesNews
     */
    public function setYesNews($yesNews)
    {
        $this->yesNews = $yesNews;
    }



    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
