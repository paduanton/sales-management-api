<?php

include __DIR__ . '/../repository/ProductRepository.php';


class ProductBusiness
{
    private $productRepository;

    public function __construct(
    ) {
        $this->productRepository = new ProductRepository();
    }

    public function getAllProducts(): array
    {
        return $this->productRepository->find();
    }

    public function storeProduct($productData = array()): array
    {
        return $this->productRepository->create($productData);
    }
}
