<?php
use App\Services\SiteService;

/**
 * @return SiteService
 */
function site(): SiteService
{
    return new SiteService;
}

/**
 * @param int $number
 * @return string
 */
function zeroBeginning(int $number): string
{
  return str_pad($number, 2, 0, STR_PAD_LEFT);
}
