<?php

namespace PubBundle\Repository;

/**
 * Publicite_countryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Publicite_countryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getPubsStat($i)
    {
        $q=$this->getEntityManager()->createQuery("Select f from PubBundle:Publicite_country f where f.idPublicite='$i' ");
        var_dump($q->getSQL());
        return $q->getResult();
    }

    public function getPubsStats($i)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql="select country_code , nbrClick from apps_countries INNER JOIN publicite_country on publicite_country.idCountry=apps_countries.id WHERE publicite_country.idPublicite =:ii ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('ii' => $i));
        return $stmt->fetchAll();
    }
    public function insertNewPubCountry($idPub,$idCountry)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql="INSERT INTO `publicite_country`(`nbrClick`, `idPublicite`, `idCountry`) VALUES (0,:idPub,:idCountry)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('idPub' => $idPub,'idCountry'=>$idCountry));

    }

    public function updateNbrClick($idPub,$countryCode)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql="UPDATE publicite_country set nbrClick=nbrClick +1 where (idPublicite=:x and idCountry in (select id from apps_countries WHERE country_code=:y)) ";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('x' => $idPub,'y'=>$countryCode));

    }

}
