<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CityPrice;

class CityPriceController extends Controller
{
    public function index()
    {
        $CityPrices = CityPrice::all();
        return view('backend.city_price.index', compact('CityPrices'));
    }
    
    public function fetch_price(Request $request)
    {
        // $CityPrices = CityPrice::where();
        $cityprice = CityPrice::where('city_from',$request->cityFrom)->where('city_to',$request->cityTo)->first();

        return response()->json(['success' => true,'message'=> 'City Price','data'=>$cityprice]);
    }

    public function create()
    {
        return view('backend.city_price.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_from' => 'required',
            'city_to' => 'required',
            'price' => 'required|numeric',
        ]);

        CityPrice::create($request->all());
        return redirect()->route('city_price.index')->with('success', 'City Price created successfully.');
    }

    // Show the form for editing a CityPrice
    public function edit($id)
    {
        $CityPrice = CityPrice::find($id);
        return view('backend.city_price.edit', compact('CityPrice'));
    }

    // Update the specified CityPrice in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'city_from' => 'required',
            'city_to' => 'required',
            'price' => 'required|numeric',
        ]);

        $CityPrice = CityPrice::find($id);
        $CityPrice->update($request->all());
        return redirect()->route('city_price.index')->with('success', 'City Price updated successfully.');
    }

    // Remove the specified CityPrice from the database
    public function destroy($id)
    {
        $CityPrice = CityPrice::find($id);
        $CityPrice->delete();
        return redirect()->route('city_price.index')->with('success', 'City Price deleted successfully.');
    }
}
