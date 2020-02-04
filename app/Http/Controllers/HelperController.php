<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\SportTypes;
use App\Models\SportComplex;
use App\Models\Infrastructure;
use App\Models\TypeCoverage;
use Illuminate\Support\Facades\Auth;

class HelperController extends Controller
{
    public function informations()
    {
        $cities = City::select('city_id', 'city_name')->orderBy('city_sort_num', 'asc')->get();
        $sport_type = SportTypes::select('st_id', 'st_name')->orderBy('st_sort_num', 'asc')->get();
        $complex = Auth::user()->complex()->select(
            'sc_city_id', 'sc_sport_type_id', 'sc_name', 'sc_addres', 'sc_work_time_weekday',
            'sc_work_time_weekend', 'sc_phone', 'sc_show_phone', 'sc_description', 
            'sc_accept_applications', 'sc_is_closed', 'sc_image'
            )->first();
        $type_coverages = TypeCoverage::orderBy('tc_sort_num', 'asc')->select('tc_id','tc_name')->get();    
        $infrastructures = Infrastructure::orderBy('inf_sort_num', 'asc')->select('inf_id','inf_name')->get();    
        $status = false;

        if (!is_null($complex)) {
            $status = true;
        }
        else {
            $complex = new SportComplex();
        }

        return response()->json([
                'cities' => $cities,
                'sport_type' => $sport_type,
                'type_coverages' => $type_coverages,
                'infrastructures' => $infrastructures,
                'complex' => $complex,
                'status' => $status
            ]);
    }

    public function inventory()
    {
        $inventories = Auth::user()->complex()
                            ->first()
                            ->inventories()
                            ->select('inv_id','inv_cost','inv_name','inv_is_active')
                            ->get();
        return $inventories;
    }
}
