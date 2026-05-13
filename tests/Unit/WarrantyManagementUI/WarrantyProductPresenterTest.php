<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\WarrantyManagementUI;

use Ksfraser\WarrantyManagement\WarrantyProductPresenter;
use PHPUnit\Framework\TestCase;

class WarrantyProductPresenterTest extends TestCase
{
    public function testConstructorAcceptsProductsArray(): void
    {
        $products = [
            ['sku_id' => 'SKU-001', 'provider_type' => 'Provider A', 'term_type' => 'Standard'],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $this->assertInstanceOf(WarrantyProductPresenter::class, $presenter);
    }

    public function testConstructorWithEmptyArray(): void
    {
        $presenter = new WarrantyProductPresenter([]);

        $this->assertInstanceOf(WarrantyProductPresenter::class, $presenter);
    }

    public function testRenderMethodExists(): void
    {
        $presenter = new WarrantyProductPresenter([]);

        $this->assertTrue(method_exists($presenter, 'render'));
    }

    public function testRenderReturnsString(): void
    {
        $presenter = new WarrantyProductPresenter([]);

        $html = $presenter->render();

        $this->assertIsString($html);
    }

    public function testRenderReturnsNoProductsMessageForEmptyArray(): void
    {
        $presenter = new WarrantyProductPresenter([]);

        $html = $presenter->render();

        $this->assertStringContainsString('wm-no-products', $html);
        $this->assertStringContainsString('No warranty products found', $html);
    }

    public function testRenderReturnsTableForNonEmptyArray(): void
    {
        $products = [
            [
                'sku_id' => 'SKU-001',
                'provider_type' => 'Provider A',
                'term_type' => 'Standard',
                'term_months' => 12,
                'cost_to_provide' => '49.99',
                'max_claims' => 2,
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringContainsString('<table', $html);
        $this->assertStringContainsString('wm-product-list', $html);
    }

    public function testRenderContainsTableHeaders(): void
    {
        $products = [
            [
                'sku_id' => 'SKU-001',
                'provider_type' => 'Provider A',
                'term_type' => 'Standard',
                'term_months' => 12,
                'cost_to_provide' => '49.99',
                'max_claims' => 2,
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringContainsString('<thead>', $html);
        $this->assertStringContainsString('<tbody>', $html);
        $this->assertStringContainsString('SKU', $html);
        $this->assertStringContainsString('Provider', $html);
        $this->assertStringContainsString('Term', $html);
        $this->assertStringContainsString('Months', $html);
        $this->assertStringContainsString('Cost', $html);
        $this->assertStringContainsString('Max Claims', $html);
    }

    public function testRenderContainsProductData(): void
    {
        $products = [
            [
                'sku_id' => 'SKU-001',
                'provider_type' => 'Provider A',
                'term_type' => 'Standard',
                'term_months' => 12,
                'cost_to_provide' => '49.99',
                'max_claims' => 2,
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringContainsString('SKU-001', $html);
        $this->assertStringContainsString('Provider A', $html);
        $this->assertStringContainsString('Standard', $html);
        $this->assertStringContainsString('12', $html);
        $this->assertStringContainsString('49.99', $html);
        $this->assertStringContainsString('2', $html);
    }

    public function testRenderEscapesHtmlCharacters(): void
    {
        $products = [
            [
                'sku_id' => '<script>alert("xss")</script>',
                'provider_type' => 'Provider & Co',
                'term_type' => 'Standard',
                'term_months' => 12,
                'cost_to_provide' => '49.99',
                'max_claims' => 2,
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringNotContainsString('<script>alert', $html);
        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringContainsString('Provider &amp; Co', $html);
    }

    public function testRenderMultipleProducts(): void
    {
        $products = [
            [
                'sku_id' => 'SKU-001',
                'provider_type' => 'Provider A',
                'term_type' => 'Standard',
                'term_months' => 12,
                'cost_to_provide' => '49.99',
                'max_claims' => 2,
            ],
            [
                'sku_id' => 'SKU-002',
                'provider_type' => 'Provider B',
                'term_type' => 'Premium',
                'term_months' => 24,
                'cost_to_provide' => '99.99',
                'max_claims' => 4,
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringContainsString('SKU-001', $html);
        $this->assertStringContainsString('SKU-002', $html);
        $this->assertStringContainsString('Provider A', $html);
        $this->assertStringContainsString('Provider B', $html);
    }

    public function testRenderHandlesMissingFields(): void
    {
        $products = [
            [
                'sku_id' => 'SKU-001',
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringContainsString('SKU-001', $html);
        $this->assertStringContainsString('<table', $html);
    }

    public function testRenderUsesTableRows(): void
    {
        $products = [
            [
                'sku_id' => 'SKU-001',
                'provider_type' => 'Provider A',
                'term_type' => 'Standard',
                'term_months' => 12,
                'cost_to_provide' => '49.99',
                'max_claims' => 2,
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringContainsString('<tr>', $html);
        $this->assertStringContainsString('</tr>', $html);
    }

    public function testRenderUsesTableCells(): void
    {
        $products = [
            [
                'sku_id' => 'SKU-001',
                'provider_type' => 'Provider A',
                'term_type' => 'Standard',
                'term_months' => 12,
                'cost_to_provide' => '49.99',
                'max_claims' => 2,
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringContainsString('<td>', $html);
        $this->assertStringContainsString('</td>', $html);
    }

    public function testRenderTableHasCorrectStructure(): void
    {
        $products = [
            [
                'sku_id' => 'SKU-001',
                'provider_type' => 'Provider A',
                'term_type' => 'Standard',
                'term_months' => 12,
                'cost_to_provide' => '49.99',
                'max_claims' => 2,
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringContainsString('<table class="wm-product-list">', $html);
        $this->assertStringContainsString('</table>', $html);
    }

    public function testRenderContainsTableHeaderRow(): void
    {
        $products = [
            [
                'sku_id' => 'SKU-001',
                'provider_type' => 'Provider A',
                'term_type' => 'Standard',
                'term_months' => 12,
                'cost_to_provide' => '49.99',
                'max_claims' => 2,
            ],
        ];
        $presenter = new WarrantyProductPresenter($products);

        $html = $presenter->render();

        $this->assertStringContainsString('<th>SKU</th>', $html);
        $this->assertStringContainsString('<th>Provider</th>', $html);
        $this->assertStringContainsString('<th>Term</th>', $html);
        $this->assertStringContainsString('<th>Months</th>', $html);
        $this->assertStringContainsString('<th>Cost</th>', $html);
        $this->assertStringContainsString('<th>Max Claims</th>', $html);
    }
}