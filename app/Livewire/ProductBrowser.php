<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class ProductBrowser extends Component
{
    public string $search = '';
    public string $category = 'all';
    
    // Track quantities for each product
    public array $quantities = [];

    public function mount($category = null)
    {
        // Initialize quantities to 1 for all products
        $products = Product::all();
        foreach ($products as $product) {
            $this->quantities[$product->id] = 1;
        }
        
        // Set initial category if provided (handle null case)
        if ($category && is_string($category)) {
            $this->category = $category;
        }
    }

    public function render()
    {
        $q = Product::query()->orderBy('name');

        if ($this->category !== 'all') {
            $q->where('category', $this->category);
        }

        if (trim($this->search) !== '') {
            $s = '%' . $this->search . '%';
            $q->where(function ($qq) use ($s) {
                $qq->where('name', 'like', $s)
                   ->orWhere('description', 'like', $s);
            });
        }

        $products = $q->get();

        // Update quantities for new products
        foreach ($products as $product) {
            if (!isset($this->quantities[$product->id])) {
                $this->quantities[$product->id] = 1;
            }
        }

        // Get user's favorite product IDs (if logged in)
        $favoriteIds = [];
        if (Auth::check()) {
            $favoriteIds = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        // group by category
        $grouped = $products->groupBy('category');

        // nice display names
        $labels = [
            'juices'        => 'Fruit Juices',
            'soft-drinks'   => 'Soft Drinks',
            'dairy'         => 'Dairy Drinks',
            'energy-drinks' => 'Energy Drinks',
        ];

        return view('livewire.product-browser', [
            'grouped' => $grouped,
            'labels'  => $labels,
            'favoriteIds' => $favoriteIds,
        ]);
    }
    
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Check if product is in stock
        if ($product->stock < $this->quantities[$productId]) {
            session()->flash('message', 'Insufficient stock available');
            return;
        }
        
        // Add to session cart (using same structure as CartController)
        $cart = session()->get('cart', []);
        $itemId = $productId;
        
        $newQty = ($cart[$itemId] ?? 0) + $this->quantities[$productId];
        
        // Apply stock protection
        if ($product->stock > 0 && $newQty > $product->stock) {
            $newQty = $product->stock;
        }
        
        $cart[$itemId] = $newQty;
        session()->put('cart', $cart);
        
        // Reset quantity to 1 after adding to cart
        $this->quantities[$productId] = 1;
        
        session()->flash('message', 'Product added to cart successfully!');
    }
    
    public function toggleFavorite($productId)
    {
        if (!Auth::check()) {
            session()->flash('message', 'Please log in to add to favorites');
            return;
        }
        
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();
        
        if ($favorite) {
            $favorite->delete();
            session()->flash('message', 'Product removed from favorites');
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
            session()->flash('message', 'Product added to favorites');
        }
    }
    
    public function updateQuantity($productId, $quantity)
    {
        $this->quantities[$productId] = max(1, intval($quantity));
    }
}