<?php

namespace Ksfraser\WarrantyManagementUI;

class WarrantyProductPresenter
{
    private array $products;
    
    public function __construct(array $products)
    {
        $this->products = $products;
    }
    
    public function render(): string
    {
        if (empty($this->products)) {
            return '<div class="wm-no-products">No warranty products found</div>';
        }
        
        $html = '<table class="wm-product-list">';
        $html .= '<thead><tr>';
        $html .= '<th>SKU</th><th>Provider</th><th>Term</th><th>Months</th><th>Cost</th><th>Max Claims</th>';
        $html .= '</tr></thead><tbody>';
        
        foreach ($this->products as $product) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($product['sku_id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($product['provider_type']) . '</td>';
            $html .= '<td>' . htmlspecialchars($product['term_type']) . '</td>';
            $html .= '<td>' . htmlspecialchars($product['term_months']) . '</td>';
            $html .= '<td>' . htmlspecialchars($product['cost_to_provide']) . '</td>';
            $html .= '<td>' . htmlspecialchars($product['max_claims']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        return $html;
    }
}