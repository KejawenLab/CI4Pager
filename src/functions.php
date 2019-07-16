<?php

declare(strict_types=1);

use KejawenLab\CodeIgniter\Pagination\Paginator;

function kejawenlab_ci4_pager(Paginator $paginator, array $config)
{
    if (!isset($config['base_url'])) {
        throw new \InvalidArgumentException('<b>base_url</b> must be set');
    }

    if (!isset($config['current_text'])) {
        throw new \InvalidArgumentException('<b>current_text</b> must be set');
    }

    if (!isset($config['total_text'])) {
        throw new \InvalidArgumentException('<b>total_text</b> must be set');
    }

    if (!isset($config['use_get_param'])) {
        $config['use_get_param'] = true;
    }

    if (!isset($config['page_param'])) {
        $config['page_param'] = 'page';
    }

    $config['current'] = $paginator->getCurrentPage();
    $config['page_count'] = $paginator->getTotalPage();
    $config['total_count'] = $paginator->getTotalData();

    if ($config['use_get_param']) {
        $config['first_link'] = sprintf('%s?%s', $config['base_url'], http_build_query($_GET + [$config['page_param'] => 1]));

        if ($paginator->isFirstPage()) {
            $config['previous_link'] = false;
            $config['current_link'] = $config['first_link'];
        } else {
            $config['previous_link'] = sprintf('%s?%s', $config['base_url'], http_build_query($_GET + [$config['page_param'] => $paginator->getPreviousPage()]));
            $config['current_link'] = sprintf('%s?%s', $config['base_url'], http_build_query($_GET + [$config['page_param'] => $paginator->getCurrentPage()]));
        }

        if ($paginator->isLastPage()) {
            $config['next_link'] = false;
            $config['last_link'] = $config['current_link'];
        } else {
            $config['next_link'] = sprintf('%s?%s', $config['base_url'], http_build_query($_GET + [$config['page_param'] => $paginator->getNextPage()]));
            $config['last_link'] = sprintf('%s?%s', $config['base_url'], http_build_query($_GET + [$config['page_param'] => $paginator->getTotalPage()]));
        }
    } else {
        $config['first_link'] = !empty($_GET) ? sprintf('%s/%d?%s', $config['base_url'], 1, http_build_query($_GET)) : sprintf('%s/%d', $config['base_url'], 1);

        if ($paginator->isFirstPage()) {
            $config['previous_link'] = false;
            $config['current_link'] = $config['first_link'];
        } else {
            $config['previous_link'] = !empty($_GET) ? sprintf('%s/%d?%s', $config['base_url'], $paginator->getPreviousPage(), http_build_query($_GET)) : sprintf('%s/%d', $config['base_url'], $paginator->getPreviousPage());
            $config['current_link'] = !empty($_GET) ? sprintf('%s/%d?%s', $config['base_url'], $paginator->getCurrentPage(), http_build_query($_GET)) : sprintf('%s/%d', $config['base_url'], $paginator->getCurrentPage());
        }

        if ($paginator->isLastPage()) {
            $config['next_link'] = false;
            $config['last_link'] = $config['current_link'];
        } else {
            $config['next_link'] = !empty($_GET) ? sprintf('%s/%d?%s', $config['base_url'], $paginator->getNextPage(), http_build_query($_GET)) : sprintf('%s/%d', $config['base_url'], $paginator->getNextPage());
            $config['last_link'] = !empty($_GET) ? sprintf('%s/%d?%s', $config['base_url'], $paginator->getTotalPage(), http_build_query($_GET)) : sprintf('%s/%d', $config['base_url'], $paginator->getTotalPage());
        }
    }

    if ($paginator->isFirstPage()) {
        $config['previous_link'] = '';
        $config['first_link'] = '';
        $config['current_link'] = sprintf('<a %s href="#">%d</a>', $config['current_link_attr'] ?? '', $paginator->getCurrentPage());
    } else {
        if ($paginator->getPreviousPage() === 1) {
            $config['previous_link'] = '';
        } else {
            $config['previous_link'] = sprintf('<a %s href="%s">&lt;</a>', $config['previous_link_attr'] ?? '', $config['previous_link']);
        }
        $config['first_link'] = sprintf('<a %s href="%s">&lt;&lt;</a>', $config['first_link_attr'] ?? '', $config['first_link']);
        $config['current_link'] = sprintf('<a %s href="#">%s</a>', $config['current_link_attr'] ?? '', $paginator->getCurrentPage());
    }

    if ($paginator->isLastPage()) {
        $config['next_link'] = '';
        $config['last_link'] = $config['current_link'];
    } else {
        if ($paginator->getNextPage() === $paginator->getTotalPage()) {
            $config['next_link'] = '';
        } else {
            $config['next_link'] = sprintf('<a %s href="%s">&gt;</a>', $config['next_link_attr'] ?? '', $config['next_link']);
        }
        $config['last_link'] = sprintf('<a %s href="%s">&gt;&gt;</a>', $config['last_link_attr'] ?? '', $config['last_link']);
    }

    if (!isset($config['template_path'])) {
        $config['template_path'] = __DIR__.'/template.tpl';
    }

    echo str_replace([
        '#currentText#',
        '#current#',
        '#pageCount#',
        '#totalText#',
        '#totalCount#',
        '#firstLink#',
        '#previousLink#',
        '#currentLink#',
        '#nextLink#',
        '#lastLink#',
    ], [
        $config['current_text'],
        $config['current'],
        $config['page_count'],
        $config['total_text'],
        $config['total_count'],
        $config['first_link'],
        $config['previous_link'],
        $config['current_link'],
        $config['next_link'],
        $config['last_link'],
    ], file_get_contents($config['template_path']));
}
