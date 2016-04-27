<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

interface Employee
{
    /**
     * @return EmployeeId
     */
    public function getIdentity();

    /**
     * @param JobTitle $title
     *
     * @return bool
     */
    public function matchTitle(JobTitle $title);
}
