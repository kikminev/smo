<?php

namespace App\Pagination;

class OffsetCalculator
{
    // The right way to include pagination details today is using the Link header introduced by RFC 8288.
    // https://www.vinaysahni.com/best-practices-for-a-pragmatic-restful-api#useful-post-responses

    public const DEFAULT_ITEMS_PER_PAGE = 20;

    public static function calculate(int $page): int
    {
        if (1 === $page) {
            $offset = 0;
        } else {
            $offset = (static::DEFAULT_ITEMS_PER_PAGE * $page) - static::DEFAULT_ITEMS_PER_PAGE + 1;
        }

        return $offset;
    }
}
