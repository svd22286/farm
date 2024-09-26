<?php
namespace App\Domain\Farm\Enums;

enum ProductType: string
{
    case MILK = 'milk';

    case EGG = 'egg';

    case GOAT_MILK = 'goat_milk';
}
