<?php

namespace ParamConverter\Test\App\Controller;

use Cake\Controller\Controller;
use DateTime;
use ParamConverter\Test\App\Model\Entity\User;

class UsersController extends Controller
{
    public function withScalar(bool $bool, int $int, float $float, string $string): void
    {
    }

    public function withEntity(User $entity): void
    {
    }

    public function withDatetime(DateTime $dateTime): void
    {
    }

    public function withNoParams(): void
    {
    }

    /**
     * @param mixed $a Param #1
     * @param mixed $b Param #2
     * @param mixed $c Param #3
     */
    public function withNoTypehint($a, $b, $c): void
    {
    }
}
