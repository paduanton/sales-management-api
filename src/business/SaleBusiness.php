<?php

include __DIR__ . '/../repository/SaleRepository.php';
include __DIR__ . '/../repository/ProductRepository.php';


class SaleBusiness
{
    private $saleRepository;
    private $productRepository;

    public function __construct(
    ) {
        $this->saleRepository = new SaleRepository();
        $this->productRepository = new ProductRepository();

    }

    public function getAllSales(): array
    {
        return $this->saleRepository->find();
    }

    public function storeSale($saleData = array()): array
    {
        return $this->saleRepository->create($saleData);
    }

    private function parseSale($saleData = array()) {
        $productIds = json_decode($saleData["producs"]);
    }
}
