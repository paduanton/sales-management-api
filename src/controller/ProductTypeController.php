<?php

include __DIR__ . '/../business/ProductTypeBusiness.php';

class ProductTypeController
{
    private $productTypeRepository;

    public function __construct()
    {
        $this->productTypeRepository = new ProductTypeBusiness();
    }

    public function index(): array
    {
        return $this->productTypeRepository->getAllProductTypes();
    }

    public function store(stdClass $productTypeData): array
    {
        $parsedProductTypeData = [
            'description' => $productTypeData->description,
            'tax_percentage' => $productTypeData->tax_percentage,
        ];

        try {
            return $this->productTypeRepository->storeProductType(
                $parsedProductTypeData
            );
        } catch (Exception $exception) {
            var_dump($exception);
        }
    }
}
