<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Traits\HandleActiveUser;

class ProductController extends Controller
{
    use HandleActiveUser;
    public function index(Request $request)
    {
        $query = Product::query();
        $activeUserData = $this->getActiveUserData();

        // search
        if ($request->has('q') && $request->q != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->q . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->q . '%');
            });
        }

        // filter category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        // return view('products.index', compact('products', 'categories'));
        return view('products.index', array_merge([
            'title' => 'Product List',
            'products' => $products,
            'categories' => $categories,
        ], $activeUserData));
    }

    public function detail($slug)
    {
        // Ambil data sosial media dari session/slug aktif
        $activeUserData = $this->getActiveUserData();

        // Produk yang sedang dibuka
        $product = Product::where('slug', $slug)->firstOrFail();

        // Ambil Youtube ID (kalau ada link)
        $youtubeId = null;
        if ($product->youtube_link) {
            $url = $product->youtube_link;

            // Format watch?v=xxxx
            if (preg_match('/v=([a-zA-Z0-9_-]{11})/', $url, $matches)) {
                $youtubeId = $matches[1];
                // Format youtu.be/xxxx
            } elseif (preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $url, $matches)) {
                $youtubeId = $matches[1];
                // Format embed/xxxx
            } elseif (preg_match('#embed/([a-zA-Z0-9_-]{11})#', $url, $matches)) {
                $youtubeId = $matches[1];
                // Format shorts/xxxx
            } elseif (preg_match('#shorts/([a-zA-Z0-9_-]{11})#', $url, $matches)) {
                $youtubeId = $matches[1];
            }
        }

        // Produk lain dengan kategori yang sama, kecuali produk ini
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('products.detail', array_merge([
            'title' => 'Product Detail | ',
            'product' => $product,
            'youtubeId' => $youtubeId, // ✅ kirim ke view
            'relatedProducts' => $relatedProducts,
        ], $activeUserData));
    }

}
