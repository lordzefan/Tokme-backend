<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\ResponseFormatter;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $address = request()->user()->addresses();
        return ResponseFormatter::success($address->pluck('api_response'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $validator = Validator::make(request()->all(), $this->getValidation());

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors());
        }

        $address = request()->user()->addresses()->create($this->prepareData());
        return $this->show($address->uuid);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $address = request()->user()->addresses()->where('uuid', $uuid)->firstOrFail();
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
     protected function getValidation()
    {
        return [
            'is_default' => 'required|in:1,0',
            'receiver_name' => 'required|string|max:30|min:3',
            'receiver_phone' => 'required|string|max:20|min:10',
            'city_id' => 'required|integer|exists:cities,uuid',
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
            'city_id',
            'district',
            'postal_code',
            'detail_address',
            'address_note',
            'type',
        ]);
        $payload['city_id'] = \App\Models\City::where('uuid', $payload['city_uuid']);
        return $payload;

    }
}
