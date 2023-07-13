<?php

namespace App\Services;

use App\Models\StoreAddress;

class StoreAddressService
{
    public function findOneById($id): StoreAddress
    {
        return StoreAddress::find($id);
    }

    public function store($data, $storeId): StoreAddress
    {
        return StoreAddress::create([
            'cep' => $data['cep'],
            'number' => $data['number'],
            'street' => $data['street'],
            'complement' => key_exists('complement', $data) ? $data['complement'] : null,
            'neighborhood' => $data['neighborhood'],
            'city' => $data['city'],
            'state' => $data['state'],
            'store_id' => $storeId,
        ]);
    }

    public function update($data, $storeAddressId): bool
    {
        $storeAddress = self::findOneById($storeAddressId);
        return $storeAddress->update($data);
    }
}
