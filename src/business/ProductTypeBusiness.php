<?php

include_once __DIR__ . '/../repository/ProductTypeRepository.php';

class ProductTypeBusiness
{
    private $productTypeRepository;

    public function __construct()
    {
        $this->productTypeRepository = new ProductTypeRepository();
    }

    public function getAllProductTypes(): array
    {
        return $this->productTypeRepository->find();
    }

    public function storeProductType($productTypeData = []): array
    {
        return $this->productTypeRepository->create($productTypeData);
    }
}
