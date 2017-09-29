<?php

namespace KvintBundle\Entity\Documents;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KvintBundle\Repository\Documents\IncomeDocumentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class IncomeDocument extends GoodsMovingDocument {

}