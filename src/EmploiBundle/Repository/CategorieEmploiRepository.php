<?php

namespace EmploiBundle\Repository;

/**
 * CategorieEmploiRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieEmploiRepository extends \Doctrine\ORM\EntityRepository
{
    public function getIdTitre($titre)
    {
        $conn = $this->getEntityManager()
                     ->getConnection();
        $sql="SELECT id FROM categorie_emploi WHERE titre_categorie ='$titre' ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findNbEmpParCat()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql="SELECT categorie_emploi.titre_categorie as titre , COUNT(emplois.idcategorie) as nb FROM `emplois` INNER JOIN categorie_emploi on emplois.idcategorie = categorie_emploi.id GROUP By idcategorie";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findNbEmpParReg()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql="SELECT emplois.emplacement as emp , COUNT(emplois.id) as nb FROM `emplois` INNER JOIN categorie_emploi on emplois.idcategorie = categorie_emploi.id GROUP By emplois.emplacement";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
