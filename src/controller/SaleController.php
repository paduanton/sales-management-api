<?php

include_once __DIR__ . '/../business/SaleBusiness.php';

class SaleController
{
    private $saleBusiness;

    public function __construct()
    {
        $this->saleBusiness = new SaleBusiness();
    }

    public function preview(string $productIds): array
    {
        return $this->saleBusiness->getSalePreview($productIds);
    }

    public function index(): array
    {
        return $this->saleBusiness->getAllSales();
    }

    public function store(stdClass $saleData): array
    {
        $parsedSaleData = [
            'description' => $saleData->description,
            'products' => json_encode($saleData->products),
        ];

        try {
            return $this->saleBusiness->storeSale($parsedSaleData);
        } catch (Exception $exception) {
            var_dump($exception);
        }
    }
}
