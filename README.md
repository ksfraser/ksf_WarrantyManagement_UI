# ksf_WarrantyManagement_UI

UI presenter components for Warranty Management.

## Components

- WarrantyProductPresenter - Render warranty product lists

## Usage

```php
use Ksfraser\WarrantyManagementUI\WarrantyProductPresenter;

$presenter = new WarrantyProductPresenter($products);
echo $presenter->render();
```