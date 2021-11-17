<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Brand;
use App\CarModel;
use App\Manufacturer;
use App\ManufacturingYear;
use App\Upload;
use App\User;
use Auth;
use App\ProductsImport;
use App\ProductsExport;
use PDF;
use Excel;
use Illuminate\Support\Str;

class ProductBulkUploadController extends Controller
{
    public function index()
    {
        if (Auth::user()->user_type == 'seller') {
            return view('frontend.user.seller.product_bulk_upload.index');
        }
        elseif (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('backend.product.bulk_upload.index');
        }
    }

    public function export(){
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function pdf_download_seller()
    {
        $users = User::where('user_type','seller')->get();

        return PDF::loadView('backend.downloads.user',[
            'users' => $users,
        ], [], [])->download('seller.pdf');

    }

    public function pdf_download_category()
    {
        $categories = Category::all();

        return PDF::loadView('backend.downloads.category',[
            'categories' => $categories,
        ], [], [])->download('category.pdf');
    }

    public function pdf_download_brand()
    {
        $brands = Brand::all();

        return PDF::loadView('backend.downloads.brand',[
            'brands' => $brands,
        ], [], [])->download('brands.pdf');
    }

    public function pdf_download_photo()
    {
        $photos = Upload::where('type', 'image')->get();

        return PDF::loadView('backend.downloads.photo',[
            'photos' => $photos,
        ], [], [])->download('photos.pdf');
    }

    public function pdf_download_pdf()
    {
        $pdfs = Upload::where('type', 'document')->get();

        return PDF::loadView('backend.downloads.pdf',[
            'pdfs' => $pdfs,
        ], [], [])->download('pdfs.pdf');
    }

    public function pdf_download_manufacturing_year()
    {
        $manufacturing_years = ManufacturingYear::all();

        return PDF::loadView('backend.downloads.manufacturing_year',[
            'manufacturing_years' => $manufacturing_years,
        ], [], [])->download('manufacturing_years.pdf');
    }

    public function pdf_download_manufacturer()
    {
        $manufacturers = Manufacturer::all();

        return PDF::loadView('backend.downloads.manufacturer',[
            'manufacturers' => $manufacturers,
        ], [], [])->download('manufacturers.pdf');
    }

    public function pdf_download_car_model()
    {
        $car_models = CarModel::orderBy('manufacturer_id', 'desc')->get();

        return PDF::loadView('backend.downloads.car_model',[
            'car_models' => $car_models,
        ], [], [])->download('car_models.pdf');
    }

    public function bulk_upload(Request $request)
    {

        if($request->hasFile('bulk_file')){
            $import = new ProductsImport;
            Excel::import($import, request()->file('bulk_file'));
            // print_r('anik');
            // die();
        //   dd('Row count: ' . $import->getRowCount());
        }


        return back();
    }

}
