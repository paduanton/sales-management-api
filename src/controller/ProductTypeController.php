<?php

include_once '../business/ProductTypeBusiness.php';

class ProductTypeController
{
    private $productTypeRepository;

    public function __construct(
        ProductTypeBusiness $productTypeBusiness,
    ) {
        $this->productTypeRepository = $productTypeBusiness;
    }

    public function index(): array
    {
        return $this->productTypeRepository->getAllProductTypes();
    }

    public function store($productTypeData = array()): array
    {
        return $this->productTypeRepository->storeProductType($productTypeData);
    }
}
