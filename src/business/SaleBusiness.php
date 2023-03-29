<?php

include_once __DIR__ . '/../repository/SaleRepository.php';

class SaleBusiness
{
    private $saleRepository;

    public function __construct()
    {
        $this->saleRepository = new SaleRepository();
    }

    public function getSalePreview($productIds): array
    {
        $ids = explode(',', $productIds);
        $parsedProductInfo = [];
        $parsedProductIds = [];

        foreach ($ids as $key => $id) {
            $parsedProductId = [];

            if (str_contains($id, '*')) {
                $parsedProductId = explode('*', $id);
                $productInfo = [
                    'id' => $parsedProductId[0],
                    'quantity' => intval($parsedProductId[1]),
                ];
            } else {
                $productInfo = [
                    'id' => $id,
                    'quantity' => 1,
                ];
            }
            array_push($parsedProductIds, $productInfo['id']);
            array_push($parsedProductInfo, $productInfo);
        }

        $productIds = implode(',', $parsedProductIds);
        $productsMoneyInfo = $this->saleRepository->getProductsMoneyData(
            $productIds
        );

        $totalSalePrice = 0;
        $totalSalePriceTaxes = 0;

        foreach ($productsMoneyInfo as $productKey => $productMoneyInfo) {
            $productsMoneyInfo[$productKey]['price_per_item'] = floatval(
                $productsMoneyInfo[$productKey]['price']
            );
            $productsMoneyInfo[$productKey]['tax_percentage'] = floatval(
                $productsMoneyInfo[$productKey]['tax_percentage']
            );
            $productsMoneyInfo[$productKey]['tax_value_per_item'] =
                $productsMoneyInfo[$productKey]['tax_percentage'] *
                $productsMoneyInfo[$productKey]['price'];

            $product = $this->_searchForProductId(
                $productMoneyInfo['product_id'],
                $parsedProductInfo
            );

            $productsMoneyInfo[$productKey]['total_tax_value'] =
                $productsMoneyInfo[$productKey]['tax_value_per_item'] *
                $product['quantity'];
            $productsMoneyInfo[$productKey]['total_price'] =
                $productsMoneyInfo[$productKey]['price_per_item'] *
                $product['quantity'];
            $productsMoneyInfo[$productKey]['total_items'] =
                $product['quantity'];

            $totalSalePrice += $productsMoneyInfo[$productKey]['total_price'];
            $totalSalePriceTaxes +=
                $productsMoneyInfo[$productKey]['total_tax_value'];

            unset($productsMoneyInfo[$productKey]['price']);
        }

        $sale = [
            'products' => $productsMoneyInfo,
            'total_sale_price' => $totalSalePrice,
            'total_sale_taxes' => $totalSalePriceTaxes,
        ];

        return $sale;
    }

    public function getAllSales(): array
    {
        $sales = $this->saleRepository->find();

        $totalSalePrice = 0;
        $totalSalePriceTaxes = 0;

        foreach ($sales as $key => $sale) {
            $totalSalePrice = 0;
            $totalSalePriceTaxes = 0;
            $products = json_decode($sale['products']);

            $getProductId = function ($product) {
                return $product->id;
            };

            $productIds = array_map($getProductId, $products);
            $productIds = implode(',', $productIds);

            $productsMoneyInfo = $this->saleRepository->getProductsMoneyData(
                $productIds
            );

            foreach ($productsMoneyInfo as $productKey => $productMoneyInfo) {
                $productsMoneyInfo[$productKey]['price_per_item'] = floatval(
                    $productsMoneyInfo[$productKey]['price']
                );
                $productsMoneyInfo[$productKey]['tax_percentage'] = floatval(
                    $productsMoneyInfo[$productKey]['tax_percentage']
                );
                $productsMoneyInfo[$productKey]['tax_value_per_item'] =
                    $productsMoneyInfo[$productKey]['tax_percentage'] *
                    $productsMoneyInfo[$productKey]['price'];

                $product = $this->_searchForProductId(
                    $productMoneyInfo['product_id'],
                    $products
                );

                $productsMoneyInfo[$productKey]['total_tax_value'] =
                    $productsMoneyInfo[$productKey]['tax_value_per_item'] *
                    $product->quantity;
                $productsMoneyInfo[$productKey]['total_price'] =
                    $productsMoneyInfo[$productKey]['price_per_item'] *
                    $product->quantity;
                $productsMoneyInfo[$productKey]['total_items'] =
                    $product->quantity;

                $totalSalePrice +=
                    $productsMoneyInfo[$productKey]['total_price'];
                $totalSalePriceTaxes +=
                    $productsMoneyInfo[$productKey]['total_tax_value'];

                unset($productsMoneyInfo[$productKey]['price']);
            }

            $sales[$key]['products'] = $productsMoneyInfo;
            $sales[$key]['total_sale_price'] = $totalSalePrice;
            $sales[$key]['total_sale_taxes'] = $totalSalePriceTaxes;
        }

        return $sales;
    }

    public function storeSale($saleData = []): array
    {
        $sale = $this->saleRepository->create($saleData);
        $sale['products'] = json_decode($sale['products']);

        return $sale;
    }

    private function _searchForProductId($id, $productList)
    {
        foreach ($productList as $key => $value) {
            if (is_array($value)) {

                if ($value['id'] == $id) {
                    return $productList[$key];
                }
            } else {
                if ($value->id == $id) {
                    return $productList[$key];
                }
            }
        }
        return null;
    }
}
