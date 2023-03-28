<?php

include __DIR__ . '/../business/ProductTypeBusiness.php';

class ProductTypeController
{
    private $productTypeBusiness;

    public function __construct()
    {
        $this->productTypeBusiness = new ProductTypeBusiness();
    }

    public function index(): array
    {
        return $this->productTypeBusiness->getAllProductTypes();
    }

    public function store(stdClass $productTypeData): array
    {
        $parsedProductTypeData = [
            'description' => $productTypeData->description,
            'tax_percentage' => $productTypeData->tax_percentage,
        ];

        try {
            return $this->productTypeBusiness->storeProductType(
                $parsedProductTypeData
            );
        } catch (Exception $exception) {
            var_dump($exception);
        }
    }
}
