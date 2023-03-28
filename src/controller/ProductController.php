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
        $parsedProductTypeData = [
            'description' => $productData->description,
            'product_type_id' => $productData->product_type_id,
        ];

        try {
            return $this->productBusiness->storeProduct(
                $parsedProductTypeData
            );
        } catch (Exception $exception) {
            var_dump($exception);
        }
    }
}
