<?php

include __DIR__ . '/../business/ProductBusiness.php';

class ProductController
{
    private $productBusiness;

    public function __construct()
    {
        $this->productBusiness = new ProductBusiness();
    }

    public function index(): array
    {
        return $this->productBusiness->getAllProducts();
    }

    public function store(stdClass $productData): array
    {
        $parsedProductData = [
            'name' => $productData->name,
            'price' => $productData->price,
            'product_type_id' => $productData->product_type_id,
        ];

        try {
            return $this->productBusiness->storeProduct(
                $parsedProductData
            );
        } catch (Exception $exception) {
            var_dump($exception);
        }
    }
}
