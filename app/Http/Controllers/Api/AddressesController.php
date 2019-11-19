<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\AddressRequest;
use App\Transformers\AddressTransformer;

class AddressesController extends Controller
{
    /**
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $addresses = Auth::guard('api')->user()->addresses();

        $this->authorize('show', $addresses->first());

        return $this->response->collection($addresses, new AddressTransformer());
    }

    /**
     * @param Address $address
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Address $address)
    {
        $this->authorize('show', $address);
        return $this->response->item($address, new AddressTransformer());
    }

    /**
     * @param AddressRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(AddressRequest $request)
    {
        $address = Address::create($request->all());
        return $this->response->created(app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.addresses.show', $address->id));
    }

    /**
     * @param AddressRequest $request
     * @param Address $address
     * @return \Dingo\Api\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(AddressRequest $request, Address $address)
    {
        $this->authorize('update', $address);
        $address->update($request->all());
        return $this->response->noContent();
    }

    /**
     * @param Address $address
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();
        return $this->response->noContent();
    }
}
