<?php
declare(strict_types=1);

namespace App\Tests\Functional\Traits;

use App\Entity\Type;
use App\Repository\TypeRepository;

trait TypeTrait
{
    public function getFirstType(): ?Type
    {
        /** @var TypeRepository $typeRepository */
        $typeRepository = static::getContainer()->get(TypeRepository::class);

        return $typeRepository->findOneBy([], ['id' => 'asc']);
    }
}
