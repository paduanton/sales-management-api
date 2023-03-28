<?php

include_once '../repository/ProductTypeRepository.php';

class ProductTypeBusiness
{
    private $productTypeRepository;

    public function __construct(
        ProductTypeRepository $productTypeRepository,
    ) {
        $this->productTypeRepository = $productTypeRepository;
    }

    public function getAllProductTypes(): array
    {
        return $this->productTypeRepository->find();
    }

    public function storeProductType($productTypeData = array()): array
    {
        return $this->productTypeRepository->create($productTypeData);
    }
}
