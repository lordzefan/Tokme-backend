<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function GetProvinces()
    {
        $provinces = \App\Models\Province::get(['uuid', 'name']);
        return ResponseFormatter::success($provinces);
    }

    public function GetCities()
    {
        $query = \App\Models\City::query();
        if (request()->province_uuid) {
            $query = $query->whereIn('province_id', function ($subQuery) {
                $subQuery->from('provinces')->where('uuid', request()->province_uuid)->select('id');
            });
        }

        if(request()->search){
                $query = $query->where('name', 'LIKE', '%' . request()->search . '%');
        }

        $cities = $query->get();
        return ResponseFormatter::success($cities->pluck('api_response'));
    }    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = request()->user()->addresses()->with('city.province')->get();
        return ResponseFormatter::success($addresses->pluck('api_response'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $validator = Validator::make(request()->all(), $this->getValidation());

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $address = request()->user()->addresses()->create($this->prepareData());
        $address->refresh();
        return $this->show($address->uuid);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $address = request()->user()->addresses()->with('city.province')->where('uuid', $uuid)->firstOrFail();
        return ResponseFormatter::success($address->api_response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $validator = Validator::make($request->all(), $this->getValidation());

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $address = request()->user()->addresses()->where('uuid', $uuid)->firstOrFail();
        $address->update($this->prepareData());
        return $this->show($address->uuid);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $address = request()->user()->addresses()->where('uuid', $uuid)->firstOrFail();
        $address->delete();
        return ResponseFormatter::success([
            'is_deleted' => true,
            ]
        );
    }

    public function setDefault(string $uuid)
    {
        $address = request()->user()->addresses()->where('uuid', $uuid)->firstOrFail();
        
        $address->update([
            'is_default' => true
        ]);
        request()->user()->addresses()->where('id', '!=', $address->id)->update([
            'is_default' => false
        ]);
        return ResponseFormatter::success([
            'is_success' => true,
        ]);
    }
           
     protected function getValidation()
    {
        return [
            'is_default' => 'required|in:1,0',
            'receiver_name' => 'required|string|max:30|min:3',
            'receiver_phone' => 'required|string|max:20|min:10',
            'city_uuid' => 'required|exists:cities,uuid',
            'district' => 'required|string|max:255',
            'postal_code' => 'required|numeric',
            'detail_address' => 'nullable|string|max:255',
            'address_note' => 'nullable|max:255',
            'type' => 'required|in:home, office',
        ];
    }

    protected function prepareData()
    {
        $payload = request()->only([
            'is_default',
            'receiver_name',
            'receiver_phone',
            'city_uuid',
            'district',
            'postal_code',
            'detail_address',
            'address_note',
            'type',
        ]);

        $payload['city_id'] = \App\Models\City::where('uuid', $payload['city_uuid'])->firstOrFail()->id;
        unset($payload['city_uuid']);

        if ($payload['is_default'] == 1) {
            request()->user()->addresses()->update([
                'is_default' => false
            ]);
        }

        return $payload;
    }
}
