<?php

declare(strict_types=1);

namespace KejawenLab\CodeIgniter\Pagination;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\ResultInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class Paginator
{
    private $data;

    private $totalData;

    private $totalPage;

    private $perPage;

    private $page;

    private $isFirstPage = true;

    private $isLastPage = false;

    public static function createFromResult(ResultInterface $result, int $page = 1, int $perPage = 17): self
    {
        return new static($result->getResultArray(), $page, $perPage);
    }

    public static function createFromQueryBuilder(BaseBuilder $queryBuilder, int $page = 1, int $perPage = 17): self
    {
        $queryBuilder->limit($perPage, ($page - 1) * $perPage);

        return new static($queryBuilder->get()->getResultArray(), $page, $perPage);
    }

    public static function createFromArray(array $records, int $page = 1, int $perPage = 17): self
    {
        return new static($records, $page, $perPage);
    }

    public function getCurrentPage(): int
    {
        return $this->page;
    }

    public function getPageLimit(): int
    {
        return $this->perPage;
    }

    public function getTotalPage(): int
    {
        return $this->totalPage;
    }

    public function getTotalData(): int
    {
        return $this->totalData;
    }

    public function getPreviousPage(): int
    {
        return $this->page -1 ;
    }

    public function getNextPage(): int
    {
        if ($this->page === $this->totalPage) {
            return 0;
        }

        return $this->page + 1;
    }

    public function getResults(): array
    {
        return $this->data;
    }

    public function isFirstPage(): bool
    {
        return $this->isFirstPage;
    }

    public function isLastPage(): bool
    {
        return $this->isLastPage;
    }

    private function __construct(array $result, int $page, int $perPage)
    {
        $this->data = array_slice($result, ($this->page - 1) * $this->perPage, $this->perPage);
        $this->page = $page;
        $this->perPage = $perPage;
        $this->totalData = count($result);
        $this->totalPage = (int) ceil($this->totalData / $this->perPage);
        $this->isFirstPage = $page === 1 ? true : false;
        $this->isLastPage = $page === $this->totalPage ? true : false;
    }
}
