<?php

include_once __DIR__ . '/../repository/SaleRepository.php';

class SaleBusiness
{
    private $saleRepository;

    public function __construct()
    {
        $this->saleRepository = new SaleRepository();
    }

    public function getAllSales(): array
    {
        $sales = $this->saleRepository->find();

        $totalProductsPrice = 0;
        $totalProductPriceTaxes = 0;

        foreach ($sales as $key => $sale) {
            $productIds = json_decode($sale['products']);
            $productIds = implode(',', $productIds);

            $productsMoneyInfo = $this->saleRepository->getProductsMoneyData(
                $productIds
            );

            foreach ($productsMoneyInfo as $productKey => $productMoneyInfo) {
                $productsMoneyInfo[$productKey]['price'] = floatval(
                    $productsMoneyInfo[$productKey]['price']
                );
                $productsMoneyInfo[$productKey]['tax_percentage'] = floatval(
                    $productsMoneyInfo[$productKey]['tax_percentage']
                );
                $productsMoneyInfo[$productKey]['tax_value'] =
                    $productsMoneyInfo[$productKey]['tax_percentage'] *
                    $productsMoneyInfo[$productKey]['price'];

                $totalProductsPrice += $productsMoneyInfo[$productKey]['price'];
                $totalProductPriceTaxes +=
                    $productsMoneyInfo[$productKey]['tax_value'];
            }

            $sales[$key]['products'] = $productsMoneyInfo;
            $sales[$key]['total_products_price'] = $totalProductsPrice;
            $sales[$key]['total_products_taxes'] = $totalProductPriceTaxes;

            $totalProductsPrice = 0;
            $totalProductPriceTaxes = 0;
        }

        return $sales;
    }

    public function storeSale($saleData = []): array
    {
        return $this->saleRepository->create($saleData);
    }
}
