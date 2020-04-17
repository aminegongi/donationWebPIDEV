<?php

namespace UserBundle\Repository;

/**
 * ConversationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConversationRepository extends \Doctrine\ORM\EntityRepository
{

    public function getSender($rec)
    {
        $q=$this->getEntityManager()->createQuery(
            "Select distinct(c.sender) from UserBundle:Conversation c where c.receiver='$rec' "
        );
        return $q->getResult();
    }

    public function getReceiver($rec)
    {
        $q=$this->getEntityManager()->createQuery(
            "Select distinct(c.receiver) from UserBundle:Conversation c where c.receiver!='$rec'"
        );
        return $q->getResult();
    }

    public function getConversation($rec)
    {
        $q=$this->getEntityManager()->createQuery(
            "Select c from UserBundle:Conversation c where c.receiver='$rec'"
        );
        return $q->getResult();
    }

    /*-----------------------------------------------------*/
    public function getSRConversation($rec,$sen)
    {
        $q=$this->getEntityManager()->createQuery(
            "Select c from UserBundle:Conversation c where (c.receiver='$rec' and c.sender='$sen') or (c.receiver='$sen' and c.sender='$rec') order by c.id ASC"
        );
        return $q->getResult();
    }



    public function getInConversation($conna)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql="select Max(dateEnvoi) as dd ,message,sender,receiver,id from conversation where (sender=".$conna." or receiver=".$conna.") Group BY sender,receiver ORDER by dd DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllConversation($mee)
    {
        $q=$this->getEntityManager()->createQuery(
            "Select c , Max(c.dateEnvoi) as HIDDEN dd from UserBundle:Conversation c where (c.receiver='".$mee."' or c.sender='".$mee."') Group BY c.sender, c.receiver Order by dd DESC"
        );
        return $q->getResult();
    }

    public function getlistConDQL($conna)
    {
        $q=$this->getEntityManager()->createQuery(
            "Select c , Max(c.dateEnvoi) as HIDDEN date from UserBundle:Conversation c where (c.receiver=".$conna." or c.sender=".$conna.") Group BY c.sender, c.receiver order by c.id DESC"
        );

        return $q->getResult();
    }

    //"Select c , Max(c.dateEnvoi) as dd  from UserBundle:Conversation c where (c.receiver='$conna' or c.sender='$conna') Group BY c.sender, c.receiver ORDER by dd DESC"
}
