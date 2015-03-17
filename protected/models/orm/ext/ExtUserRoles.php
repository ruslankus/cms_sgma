<?php

Class ExtUserRoles extends UserRoles
{
    const ROLE_ROOT = 1;
    const ROLE_ADMIN = 2;
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}