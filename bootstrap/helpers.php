<?php
use App\Services\SiteService;

/**
 * @return SiteService
 */
function site(): SiteService
{
    return new SiteService;
}
