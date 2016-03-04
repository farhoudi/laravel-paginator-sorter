# Laravel Paginator Sorter
A helper to make your tables sortable

## Installation
A simple way to use this library in laravel 4.2. You can use it in other versions as you wish.

1. Create a file named "helpers.php" in "app" folder. (beside filters.php and routes.php)
2. Create a folder named "helpers" in app folder. (beside your helpers.php file)
3. Put "pagination_sort_helper.php" file in "helpers" folder.
4. Include (require) "pagination_sort_helper.php" file in helpers.php.
in helpers.php write:
    
    ```php
        require_once __DIR__ . '/helpers/pagination_sort_helper.php';
    ```
5. Load helpers.php file in "app/start/global.php". At the end of the file:
    
    ```php
        require app_path() . '/filters.php';
        require app_path() . '/helpers.php';
    ```
	
## Usage
* To make your view tables sortable you need to make your table headers as a link.
For example in "app/view/transactions.blade.php" for a custom column write:
```html
<th>{{ link_to_route('transactions.index', trans('transactions.created_at'), get_sort_url('created_at')) }}</th>
```
This link will redirect to same page will some get parameters as your column name.
* For fetching result sorted you need to use "get_sorted" function to set needed conditions to your query.
For example in "app/controllers/TransactionsController.php" just write:
```php
$transactions = get_sorted($transactions, 'transactions')->paginate(10);
```
* Now for pagination links (to include your sort parameters) you can use "get_pagination_links" function.
For example in "app/view/transactions.blade.php" at the end of the page write:
```php
{{ get_pagination_links($transactions) }}
```