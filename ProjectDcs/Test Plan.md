# Warranty Management UI - Test Plan

## Document Information

| Field | Value |
|-------|-------|
| Document Title | Test Plan |
| Module | ksf_WarrantyManagement_UI |
| Version | 1.0.0 |
| Author | KSF Development Team |
| Last Updated | May 2026 |

---

## 1. Test Overview

### 1.1 Scope

Unit tests for WarrantyProductPresenter component.

---

## 2. Test Cases

### 2.1 TC-001: Render Product Table

**Test ID:** TC-001  
**Priority:** High

**Test Data:**
```php
$products = [
    [
        'sku_id' => 'WARR-001',
        'provider_type' => 'Manufacturer',
        'term_type' => 'Fixed',
        'term_months' => 12,
        'cost_to_provide' => 50.00,
        'max_claims' => 3,
    ]
];
```

**Steps:**
1. Create WarrantyProductPresenter with products
2. Call render()
3. Assert table contains 'wm-product-list' class
4. Assert header row contains 'SKU', 'Provider', etc.
5. Assert data row contains product values

**Expected Result:** Complete HTML table

**Pass Criteria:** All assertions pass

---

### 2.2 TC-002: Empty State

**Test ID:** TC-002  
**Priority:** High

**Steps:**
1. Create WarrantyProductPresenter with empty array
2. Call render()
3. Assert output contains 'wm-no-products' class
4. Assert contains 'No warranty products found'

**Expected Result:** Empty state div

**Pass Criteria:** Correct empty state rendered

---

### 2.3 TC-003: Single Product Render

**Test ID:** TC-003  
**Priority:** Medium

**Steps:**
1. Create presenter with single product
2. Assert table has exactly one tbody row
3. Assert all columns populated

**Expected Result:** Single row table

---

### 2.4 TC-004: XSS Prevention

**Test ID:** TC-004  
**Priority:** High

**Test Data:**
```php
$products = [
    [
        'sku_id' => '<script>alert("xss")</script>',
        'provider_type' => 'Manufacturer',
        // ... other fields
    ]
];
```

**Steps:**
1. Create presenter with XSS payload
2. Call render()
3. Assert output does NOT contain `<script>` tag
4. Assert output contains escaped text `&lt;script&gt;`

**Expected Result:** Script rendered as text

---

### 2.5 TC-005: Multiple Products

**Test ID:** TC-005  
**Priority:** Medium

**Steps:**
1. Create presenter with 3 products
2. Assert table has 3 tbody rows
3. Assert each row contains correct data

**Expected Result:** All products rendered

---

## 3. Traceability Matrix

| Requirement | Test Case |
|-------------|-----------|
| FR-UI-001 | TC-001, TC-003, TC-005 |
| FR-UI-002 | TC-002 |
| FR-UI-003 | TC-004 |

---

## 4. Revision History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0.0 | May 2026 | KSF Development Team | Initial test plan |