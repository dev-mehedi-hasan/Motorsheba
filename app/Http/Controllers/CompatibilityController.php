<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ManufacturingYear;
use App\Manufacturer;
use App\CarModel;

class CompatibilityController extends Controller
{
	// Manufacturing Year
    public function manufacturing_year(Request $request)
    {
    	$sort_search =null;
        $manufacturing_years = ManufacturingYear::orderBy('year', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $manufacturing_years = $manufacturing_years->where('year', 'like', '%'.$sort_search.'%');
        }
        $manufacturing_years = $manufacturing_years->paginate(15);
        return view('backend.product.compatibility.manufacturing_year.index', compact('manufacturing_years'));
    }

    public function store_manufacturing_year(Request $request)
    {
    	$manufacturing_year = new ManufacturingYear;
    	$request->validate(
    		[
		    	'year' => 'required|unique:manufacturing_years',
			],
			[
    			'year.unique' => 'This year has been taken already.Please select another year.',
    		]
		);
		$manufacturing_year->year = $request->year;
		$manufacturing_year->save();
		flash(translate( $request->year. ' has been inserted as manufacturing year successfully'))->success();
        return redirect()->route('compatibility.manufacturing_year');
    }

    public function destroy_manufacturing_year(Request $request, $id)
    {
        $manufacturing_year = ManufacturingYear::find($id);
        $manufacturing_year->delete();
        flash(translate('A manufacturing year has been deleted successfully'))->success();
        return redirect()->route('compatibility.manufacturing_year');
    }

	// Manufacturer
    public function manufacturer(Request $request)
    {
    	$sort_search =null;
        $manufacturers = Manufacturer::orderBy('name', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $manufacturers = $manufacturers->where('name', 'like', '%'.$sort_search.'%');
        }
        $manufacturers = $manufacturers->paginate(15);
        return view('backend.product.compatibility.manufacturer.index', compact('manufacturers'));
    }

    public function store_manufacturer(Request $request)
    {
    	$manufacturer = new Manufacturer;
    	$request->validate(
    		[
		    	'name' => 'required|unique:manufacturers',
			],
			[
    			'name.unique' => 'This name has been taken already.',
    		]
		);
		$manufacturer->name = $request->name;
		$manufacturer->save();
		flash(translate( $request->name. ' has been inserted as a manufacturer successfully'))->success();
        return redirect()->route('compatibility.manufacturer');
    }

    public function edit_manufacturer(Request $request, $id)
    {
        $manufacturer  = Manufacturer::findOrFail($id);
        return view('backend.product.compatibility.manufacturer.edit', compact('manufacturer'));
    }

    public function update_manufacturer(Request $request, $id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $request->validate(
    		[
		    	'name' => 'required|unique:manufacturers,name,'.$id,
			],
			[
    			'name.unique' => 'This name has been taken already.',
    		]
		);
        $manufacturer->name = $request->name;
        $manufacturer->save();
        flash(translate( $request->name. ' has been update as a manufacturer successfully'))->success();
        return redirect()->route('compatibility.manufacturer');
    }

    public function destroy_manufacturer(Request $request, $id)
    {
        $manufacturer = Manufacturer::find($id);
        $manufacturer->delete();
        flash(translate('A manufacturer has been deleted successfully'))->success();
        return redirect()->route('compatibility.manufacturer');
    }

    // Car Model
    public function car_model(Request $request)
    {
        $sort_search =null;
        $car_models = CarModel::orderBy('manufacturer_id', 'desc');

        if ($request->has('search')){
            $sort_search = $request->search;
            $car_models = $car_models->where('model', 'like', '%'.$sort_search.'%')->orWhereHas('manufacturer', function($q) use($sort_search) {
                $q->where('name', 'like', '%'.$sort_search.'%');
            });
        }
        $car_models = $car_models->paginate(15);

        $manufacturers = Manufacturer::orderBy('name', 'desc')->get();
        return view('backend.product.compatibility.car_model.index', compact('car_models','manufacturers'));
    }

    public function store_car_model(Request $request)
    {
        $request->validate(
    		[
		    	'manufacturer_id' => 'required',
                'model' => 'required',
			],
		);

        $car_model = CarModel::where('manufacturer_id',$request->manufacturer_id)->where('model', $request->model)->first();

        if($car_model != null){
            flash(translate( $request->model. ' with same manufacturer has been taken already.'))->error();
            return redirect()->route('compatibility.car_model');
        }
        else{
            $car_model = new CarModel;
            $car_model->manufacturer_id = $request->manufacturer_id;
            $car_model->model = $request->model;
            $car_model->save();
            flash(translate( $request->model. ' has been inserted as a car model successfully'))->success();
            return redirect()->route('compatibility.car_model');
        }
    }

    public function edit_car_model(Request $request, $id)
    {
        $car_model  = CarModel::findOrFail($id);
        $manufacturers = Manufacturer::orderBy('name', 'desc')->get();
        return view('backend.product.compatibility.car_model.edit', compact('car_model', 'manufacturers'));
    }

    public function update_car_model(Request $request, $id)
    {
        $request->validate(
    		[
		    	'manufacturer_id' => 'required',
                'model' => 'required',
			],
		);
        $car_model = CarModel::where('manufacturer_id',$request->manufacturer_id)->where('model', $request->model)->where('id', '!=', $id)->first();
        if($car_model != null){
            flash(translate( $request->model. ' with same manufacturer has been taken already.'))->error();
            return redirect()->route('compatibility.car_model.edit', $id);
        }
        else{
            $car_model = CarModel::findOrFail($id);
            $car_model->manufacturer_id = $request->manufacturer_id;
            $car_model->model = $request->model;
            $car_model->save();
            flash(translate( $request->model. ' has been update as a car model successfully'))->success();
            return redirect()->route('compatibility.car_model');
        }
    }

    public function destroy_car_model(Request $request, $id)
    {
        $car_model = CarModel::find($id);
        $car_model->delete();
        flash(translate('A car model has been deleted successfully'))->success();
        return redirect()->route('compatibility.car_model');
    }
}
