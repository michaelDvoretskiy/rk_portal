<?php

namespace KvintBundle\Entity\Documents;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class IncomeDocument extends GoodsMovingDocument {

}