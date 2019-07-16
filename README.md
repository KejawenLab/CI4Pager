# CodeIgniter 4 Pagination Library

## Requirement

* PHP 7.2 or above

* CodeIgniter v4

## Installation

`composer req kejawenlab/ci4pager`

## Usage

* From Query Result

```php
// In your controller
use KejawenLab\CodeIgniter\Pagination\Paginator;

$results = $db->query('SELECT * FROM users');
$page = 1;

$paginator = Paginator::createFromResult($results, $page);

echo view('records', ['paginator' => $paginator]);

//In your view
foreach ($paginator->getResults() as $result) {
    //your result here
}

kejawenlab_ci4_pager($paginator, [
    'base_url' => 'http://base_url.com/users',
    'current_text' => 'Current Page',
    'total_text' => 'Total Records',
]);
```

* From Query Builder

```php
// In your controller
use KejawenLab\CodeIgniter\Pagination\Paginator;

$queryBuilder = $db->table('users');
$page = 1;

$paginator = Paginator::createFromQueryBuilder($queryBuilder, $page);

echo view('records', ['paginator' => $paginator]);

//In your view
foreach ($paginator->getResults() as $result) {
    //your result here
}

kejawenlab_ci4_pager($paginator, [
    'base_url' => 'http://base_url.com/users',
    'current_text' => 'Current Page',
    'total_text' => 'Total Records',
]);
```

* From Array

```php
// In your controller
use KejawenLab\CodeIgniter\Pagination\Paginator;

$results = $db->table('users')->get()->getResultArray();
$page = 1;

$paginator = Paginator::createFromArray($results, $page);

echo view('records', ['paginator' => $paginator]);

//In your view
foreach ($paginator->getResults() as $result) {
    //your result here
}

kejawenlab_ci4_pager($paginator, [
    'base_url' => 'http://base_url.com/users',
    'current_text' => 'Current Page',
    'total_text' => 'Total Records',
]);
```

## Config Available

* `base_url`: required

* `current_text`: required

* `total_text`: required

* `use_get_param`: optional (default: true)

* `page_param`: when use `use_get_param` (default: page)

* `first_link_attr`: extra markup for first link (ex: `class="btn btn-success" id="first-page"`)

* `previous_link_attr`: extra markup for previous link

* `current_link_attr`: extra markup for current link

* `next_link_attr`: extra markup for next link

* `last_link_attr`: extra markup for last link

* `template_path`: optional (default: [template.tpl](src/template.tpl))
