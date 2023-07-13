<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Helpers\Logger;
use App\Services\StoreService;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Store;
use App\Services\StoreAddressService;

class StoreController extends Controller
{
    public function __construct(
        protected StoreService $storeService,
        protected StoreAddressService $storeAddressService
    ) {
    }

    public function listStores(): JsonResponse
    {
        try {
            $stores = $this->storeService->listStores();

            return response()->json($stores);
        } catch (Exception $e) {
            $error = 'Unable to load the list of all stores.';
            Logger::log($e, $error);

            return response()->json(['errors' => $error], 500);
        }
    }

    public function listUserStores(): JsonResponse
    {
        try {
            $userStores = $this->storeService->listUserStores();

            return response()->json($userStores);
        } catch (Exception $e) {
            $error = 'Unable to load the list of all user stores.';
            Logger::log($e, $error);

            return response()->json(['errors' => $error], 500);
        }
    }

    public function store(StoreStoreRequest $request): JsonResponse
    {
        DB::beginTransaction();

        $data = $request->all();

        try {
            $storeCreated = $this->storeService->store($data);

            $this->storeAddressService->store($data['address'], $storeCreated['id']);

            $store = $this->storeService->findOneWithAddress($storeCreated['id']);

            DB::commit();

            return response()->json($store);
        } catch (Exception $e) {
            DB::rollBack();

            $error = 'Unable to create a new store.';
            Logger::log($e, $error);

            return response()->json(["error" => $error], 500);
        }
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        DB::beginTransaction();

        $data = $request->all();

        try {
            $storeUpdated = $this->storeService->update($data, $store);

            if (!$storeUpdated) {
                DB::rollBack();

                $message = 'You do not have permission to update this store.';
                return response()->json(["message" => $message], 403);
            }

            $storeWithAddress = $this->storeService->findOneWithAddress($store['id']);

            $this->storeAddressService->update($data['address'], $storeWithAddress->storeAddress['id']);

            DB::commit();

            return response()->json(null, 204);
        } catch (Exception $e) {
            DB::rollBack();

            $error = 'Unable to update the selected store.';
            Logger::log($e, $error);

            return response()->json(['errors' => $error], 500);
        }
    }


    public function destroy(Store $store): JsonResponse
    {
        DB::beginTransaction();
        try {
            $userStore = $this->storeService->delete($store);

            if (!$userStore) {
                DB::rollBack();

                $message = 'You do not have permission to delete this store.';
                return response()->json(["message" => $message], 403);
            }

            DB::commit();

            return response()->json(null, 204);
        } catch (Exception $e) {
            DB::rollBack();

            $error = 'Unable to delete the selected store.';
            Logger::log($e, $error);

            return response()->json(['errors' => $error], 500);
        }
    }
}
