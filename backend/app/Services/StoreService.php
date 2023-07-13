<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Store;

class StoreService
{
    /**
     * @return Collection<int, Store>
     */
    public function listStores(): Collection
    {
        return Store::withAddress()->get();
    }

    /**
     * @return Collection<int, Store>
     */
    public function listUserStores(): Collection
    {
        $userId = Auth::id();

        return Store::withAddress()->where('user_id', '=', $userId)->get();
    }

    public function store($data): Store
    {
        return Store::create([
            'name' => $data['name'],
            'description' => key_exists('description', $data) ? $data['description'] : null,
            'cnpj' => $data['cnpj'],
            'user_id' => Auth::id()
        ]);
    }

    public function update($data, $store): bool
    {
        if ($store->user_id != Auth::id()) {
            return false;
        }

        return $store->update($data);
    }

    public function delete($store): bool
    {
        if ($store->user_id != Auth::id()) {
            return false;
        }

        $store->delete();
        return true;
    }

    public function findOneWithAddress($id)
    {
        return Store::withAddress()->find($id);
    }
}
