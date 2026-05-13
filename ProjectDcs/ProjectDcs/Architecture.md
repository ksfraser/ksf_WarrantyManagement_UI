# Warranty Management UI - Architecture

## Document Information

| Field | Value |
|-------|-------|
| Document Title | Technical Architecture Specification |
| Module | ksf_WarrantyManagement_UI |
| Version | 1.0.0 |
| Author | KSF Development Team |
| Last Updated | May 2026 |

---

## 1. Architecture Overview

### 1.1 Design Philosophy

The `ksf_WarrantyManagement_UI` module follows the **Platform Adapter** pattern, serving as the UI presentation layer for the `ksf_WarrantyManagement` business logic. The presenter transforms structured data into FrontAccounting-compatible HTML output.

### 1.2 Module Structure

```
ksf_WarrantyManagement_UI/
├── src/
│   └── Ksfraser/
│       └── WarrantyManagement/
│           └── WarrantyProductPresenter.php
├── tests/
│   └── Unit/
│       └── WarrantyProductPresenterTest.php
├── composer.json
└── ProjectDcs/
    └── ProjectDcs/
```

### 1.3 Namespace Convention

```php
namespace Ksfraser\WarrantyManagement;
```

The namespace aligns with the KSF convention for UI adapters.

---

## 2. Component Architecture

### 2.1 WarrantyProductPresenter

```php
namespace Ksfraser\WarrantyManagement;

class WarrantyProductPresenter
{
    private array $products;
    
    public function __construct(array $products);
    public function render(): string;
}
```

**Responsibilities:**
- Accept warranty product data array
- Transform data into HTML table
- Handle empty state
- Ensure output escaping

### 2.2 Data Flow

```
Business Logic (ksf_WarrantyManagement)
    │
    ▼
WarrantyProductPresenter::__construct(products)
    │
    ▼
WarrantyProductPresenter::render()
    │
    ▼
HTML Output (FrontAccounting)
```

---

## 3. Output Specification

### 3.1 Product Table HTML

```html
<table class="wm-product-list">
    <thead>
        <tr>
            <th>SKU</th>
            <th>Provider</th>
            <th>Term</th>
            <th>Months</th>
            <th>Cost</th>
            <th>Max Claims</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>WARR-001</td>
            <td>Manufacturer</td>
            <td>Fixed</td>
            <td>12</td>
            <td>50.00</td>
            <td>3</td>
        </tr>
    </tbody>
</table>
```

### 3.2 Empty State HTML

```html
<div class="wm-no-products">No warranty products found</div>
```

### 3.3 Data Mapping

| Product Field | HTML Column |
|--------------|-------------|
| sku_id | SKU |
| provider_type | Provider |
| term_type | Term |
| term_months | Months |
| cost_to_provide | Cost |
| max_claims | Max Claims |

---

## 4. Security Implementation

### 4.1 XSS Prevention

All dynamic content is escaped using `htmlspecialchars()`:

```php
'<td>' . htmlspecialchars($product['sku_id']) . '</td>'
```

### 4.2 Output Validation

- All HTML tags properly closed
- Valid HTML table structure
- No inline styles (CSS classes only)

---

## 5. Dependencies

### 5.1 Internal Dependencies

| Module | Relationship |
|--------|--------------|
| `ksf_WarrantyManagement` | Data provider |

### 5.2 External Dependencies

| Package | Version | Purpose |
|---------|---------|---------|
| PHP | 8.0+ | Runtime |

---

## 6. Testing Strategy

### 6.1 Unit Tests

| Test | Coverage |
|------|----------|
| Render with products | Full table generation |
| Render empty array | Empty state |
| Render single product | Single row |
| Escaping special characters | XSS prevention |

---

## 7. Revision History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0.0 | May 2026 | KSF Development Team | Initial specification |