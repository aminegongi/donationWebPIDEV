<?php

namespace PubBundle\Repository;

/**
 * Pub_userRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Pub_userRepository extends \Doctrine\ORM\EntityRepository
{
    public function insertNewPubUser($idPub,$idUser)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql="INSERT INTO `pub_user`( `idPub`, `idUser`) VALUES (:idPub,:idUser)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('idPub' => $idPub,'idUser'=>$idUser));

    }
}
