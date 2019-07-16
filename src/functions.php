<?php

declare(strict_types=1);

use KejawenLab\CodeIgniter\Pagination\Paginator;

function kejawenlab_ci4_pager(Paginator $paginator, array $config)
{
    $config['current'] = $paginator->getCurrentPage();
    $config['pageCount'] = $paginator->getTotalPage();
    $config['totalCount'] = $paginator->getTotalData();
}
