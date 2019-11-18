<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Transformers\AddressTransformer;

class AddressesController extends Controller
{
    public function index()
    {
        $addresses = Auth::guard('api')->user()->addresses();
        return $this->response->collection($addresses, new AddressTransformer());
    }

    public function show(Address $address)
    {
        return $this->response->item($address, new AddressTransformer());
    }

    public function store(AddressRequest $request)
    {
        $address = Address::create($request->all());
        return $this->response->created(app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.addresses.show', $address->id));
    }

    public function update(AddressRequest $request, Address $address)
    {
        $address->update($request->all());
        return $this->response->noContent();
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return $this->response->noContent();
    }
}
