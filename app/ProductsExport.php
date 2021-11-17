<?php

namespace App;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'Added_By',
            'Seller_User_Id',
            'Product_Name',
            'Category_Id',
            'Brand_Id',
            'Tags',
            'Photos_Id',
            'Thumbnail_Id',
            'Price',
            'Stock',
            'Product_Code',
            'PDF_Specification_Id',
            'Manufacturing_Year_Id',
            'Manufacturer_Id',
            'Car_Model_Id',
            'Refund_Status',
            'Featured_Status',
            'Published_Status',
            'Short_Description',
            'Description',
        ];
    }

    /**
    * @var Product $product
    */
    public function map($product): array
    {
        $qty = 0;
        foreach ($product->stocks as $key => $stock) {
            $qty += $stock->qty;
        }
        foreach ($product->stocks as $key => $stock) {
            $sku = $stock->sku;
        }
        return [
            $product->added_by,
            $product->user_id,
            $product->name,
            $product->category_id,
            $product->brand_id,
            $product->tags,
            $product->photos,
            $product->thumbnail_img,
            $product->unit_price,
            $qty,
            $sku,
            $product->pdf,
            $product->manufacturing_year,
            $product->manufacturer,
            $product->car_model,
            $product->refundable,
            $product->featured,
            $product->published,
            $product->short_description,
            $product->description,
        ];
    }
}
