<?php

namespace App\Http\Controllers;

use App\Models\DigitalProduct;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class DigitalProductController extends Controller
{
    /**
     * Display a listing of all digital products.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $agent = new Agent();
        $products = DigitalProduct::active()
            ->when(request('type') === 'promo', function ($query) {
                return $query->where('is_promo', true)
                    ->where('promo_ends_at', '>', now());
            })
            ->paginate(12);

        if (!$products) {
            $products = new \Illuminate\Pagination\LengthAwarePaginator(
                collect([]), // empty collection
                0, // total items
                12, // items per page
                1 // current page
            );
        }

        return view(
            $agent->isMobile() ? 'pages.mobile.products.index' : 'pages.desktop.products.index',
            compact('products')
        );
    }

    public function show(DigitalProduct $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $agent = new Agent();
        
        // Get related products (same price range or promotional status)
        $relatedProducts = DigitalProduct::active()
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->whereBetween('sharing_price', [
                    $product->sharing_price * 0.8,
                    $product->sharing_price * 1.2
                ])
                ->orWhere('is_promo', $product->is_promo);
            })
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view(
            $agent->isMobile() ? 'pages.mobile.products.show' : 'pages.desktop.products.show',
            compact('product', 'relatedProducts')
        );
    }
} 