<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use App\Models\Part;
use App\Models\Customer;

use App\Http\Resources\PartResource;
use App\Http\Resources\PartCollection;
use App\Http\Requests\IndexPartRequest;

class PartController extends Controller
{
    function index(IndexPartRequest $request)
    {
        $query = Part::query();

        $query->where('status','!=',1)
            ->where('partId','>',0);

        $filters = ($request->isJson()) ? $request->json()->all() : $request->all();
        foreach($filters as $key => $value)
        {
            $this->filterWhen($query,$key,$value,$this->getRelation($key));
        }

        $query->with('customer','materialSpec','materialType')
            ->take(1000)
            ->orderBy('partId','DESC');

        $data = new PartCollection(new PartResource($query->get()));

        dump($data->toJson(JSON_PRETTY_PRINT));

        return;
    }

    private function getRelation($field)
    {
        $customerFields = Schema::getColumnListing((new Customer)->getTable());
        if(in_array($field,$customerFields)) return 'customer';
        if($field=='materialType') return 'materialType';
        return '';
    }

    private function filterWhen($query,$column,$value,$relation='')
    {
        $query->when($value!=null AND $value!='', function ($q) use($column,$value,$relation){
            if($relation!='')
            {
                return $q->whereHas($relation,function($qq) use($column,$value,$relation){
                    return $qq->where($column,$value);
                });
            }

            return $q->where($column,$value);
        });
    }    
}
