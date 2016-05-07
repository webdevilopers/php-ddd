<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\DomainModel\Identity;

interface Identity
{
    /**
     * @return string
     */
    public function getEntityClass();

    /**
     * @return mixed
     */
    public function id();
}
