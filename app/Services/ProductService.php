<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService
{
    private $cartService;

    public function __construct(Product $model, CartService $cartService)
    {
        parent::__construct($model);
        $this->cartService = $cartService;
    }

    /**
     * @param string|array $with
     * @return LengthAwarePaginator|void
     */
    public function getPaginate(string|array $with = [])
    {
        try {
            return $this->model::query()
                ->latest()
                ->with($with)
                ->paginate();
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            DB::beginTransaction();
            $product = $this->model::findOrfail($id);

            // Remove items from cart
            $cart_items = $this->cartService->getCartItems()['items'];
            $cart_item_index = array_search($product->id, array_column($cart_items, 'modelId'));
            if (strlen($cart_item_index)){
                $this->cartService->removeFromCart($cart_item_index);
            }

            $product->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->logErrorResponse($e);
        }
    }
}
