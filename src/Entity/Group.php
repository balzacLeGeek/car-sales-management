<?php

namespace App\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    const ROLE_CUSTOMER_CREATE = 'ROLE_CUSTOMER_CREATE';
    const ROLE_CUSTOMER_EDIT = 'ROLE_CUSTOMER_EDIT';
    const ROLE_PAYMENT_METHOD_CREATE = 'ROLE_PAYMENT_METHOD_CREATE';
    const ROLE_PAYMENT_METHOD_EDIT = 'ROLE_PAYMENT_METHOD_EDIT';
    const ROLE_PAYMENT_METHOD_REMOVE = 'ROLE_PAYMENT_METHOD_REMOVE';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(name="id", type="guid")
     */
     protected $id;

     public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles);
    }
}