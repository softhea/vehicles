<?php
declare(strict_types=1);

namespace App\Tests\Functional\Traits;

use App\Entity\User;
use App\Repository\UserRepository;

trait UserTrait
{
    public function getUser(string $email): ?User
    {
        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);

        return $userRepository->findOneBy(['email' => $email]);
    }
}
