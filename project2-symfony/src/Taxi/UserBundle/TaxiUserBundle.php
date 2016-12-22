<?php
namespace Taxi\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TaxiUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}