<?php

namespace App\Http\Controllers;

use App\Satreps_image_database;
use App\Object_name;
use Illuminate\Http\Request;
use \App\Ages;
use \App\Nationalities;

use App\Factors;
use App\Type_of_image;

class PagesController extends Controller
{

    // public function management(Request $request){
    // }

    public function object(Request $request)
    {
        $object_type = $request->object_type;
        $count = 1;

        $objects = Satreps_image_database::where('image_type', $object_type)->orderByRaw('RAND()')->simplePaginate(1); //pagenateするとtake(3)が無視される
        $object_name = Object_name::all();
        $type_of_image = Type_of_image::all();
        $factors = Factors::all();
        return view('pages.object', ['objects' => $objects, 'object_type' => $object_type, 'type_of_image' => $type_of_image, 'object_name' => $object_name, 'count' => $count, 'factors' => $factors,]);
    }

    //Appを表示
    public function select()
    {
        $ages = Ages::all();
        $nationalities = Nationalities::all();

        // dd($image_database);
        return view('pages.select', [
            'ages' => $ages, 'nationalities' => $nationalities,
        ]);
    }


    public function selection(Request $request)
    {
        // dd($request);
        // $age = $request->get('age');
        $images = Object_name::orderby('id', 'desc')->Paginate(30);
        $request->session()->put('age', request()->get('age'));
        $request->session()->put('nationality', request()->get('nationality'));
        $request->session()->put('seibetu', request()->get('seibetu'));
        // dump($request);
        return view('pages.questionnaire')->with('images', $images);
    }
}
