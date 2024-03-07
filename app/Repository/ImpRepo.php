<?php

namespace App\Repository;

use Keepa\API\Request;
use Keepa\API\ResponseStatus;
use Keepa\helper\CSVType;
use Keepa\helper\CSVTypeWrapper;
use Keepa\helper\KeepaTime;
use Keepa\helper\ProductAnalyzer;
use Keepa\helper\ProductType;
use Keepa\KeepaAPI;
use Keepa\objects\AmazonLocale;

class ImpRepo implements ImpInterface
{

    public function find($skn)
    {
        $find = $skn;
        $res = [];
        $api = new KeepaAPI("625of48c43a5ubg51paai86ovkel2o4ujfrdi7tnv1hiov49lfooe6hkebq2v8pb");
        $r = Request::getProductRequest(AmazonLocale::US, 0, null, null, 0, true, [$find]);

        $response = $api->sendRequestWithRetry($r);

        switch ($response->status) {
            case ResponseStatus::OK:
                if (!is_array($response->products)) {
                    return null;
                }
                // iterate over received product information
                foreach ($response->products as $product) {
                    if ($product->productType == ProductType::STANDARD || $product->productType == ProductType::DOWNLOADABLE) {
                        //get basic data of product and print to stdout
                        $currentAmazonPrice = ProductAnalyzer::getLast($product->csv[CSVType::AMAZON], CSVTypeWrapper::getCSVTypeFromIndex(CSVType::AMAZON));
                        if ($currentAmazonPrice === -1) {
                            $currentAmazonPrice = ProductAnalyzer::calcWeightedMean($product->csv[CSVType::AMAZON], KeepaTime::nowMinutes(), 90, CSVTypeWrapper::getCSVTypeFromIndex(CSVType::AMAZON));
                        }
                        if ($currentAmazonPrice === -1) {
                            $price_csv = $product->csv[1];
                            for ($index = count($price_csv) - 1; $index >= 0; $index -= 2) {
                                if ($price_csv[$index] !== -1) {
                                    $currentAmazonPrice = $price_csv[$index];
                                    break;
                                }
                            }
                        }
                        $length = number_format($product->packageLength / 25.4, 2);
                        $height = number_format($product->packageHeight / 25.4, 2);
                        $width = number_format($product->packageWidth / 25.4, 2);
                        $image = $product->imagesCSV ? "https://m.media-amazon.com/images/I/" . explode(",", $product->imagesCSV)[0] : null;

                        $d_weight = number_format(($length * $width * $height) / 139, 2);
                        $res['title'] = $product->title;
                        $res['image'] = $image;
                        $res['price'] = $currentAmazonPrice != -1 ? $currentAmazonPrice / 100 : null;
                        $res['height'] = $height;
                        $res['length'] = $length;
                        $res['width'] = $width;
                        $res['weight'] = number_format($product->packageWeight / 453.6, 2);
                        $res['d_weight'] = $d_weight;
                        $res['description'] = $product->description ? $product->description : null;
                        $res['items'] = $product->numberOfItems ? $product->numberOfItems : 1;
                        $res['size'] = $product->size ? $product->size : null;
                        $res['color'] = $product->color ? $product->color : null;

                        return $res;
                    } else {
                        return null;
                        break;
                    }
                }
                break;
            default:
                return null;
        }
        return null;
    }
}
