<?php

include __DIR__ . '/../repository/SaleRepository.php';


class SaleBusiness
{
    private $saleRepository;

    public function __construct(
    ) {
        $this->saleRepository = new SaleRepository();
    }

    public function getAllSales(): array
    {
        return $this->saleRepository->find();
    }

    public function storeSale($productTypeData = array()): array
    {
        return $this->saleRepository->create($productTypeData);
    }
}
