<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductBrowser extends Component
{
    public string $search = '';
    public string $category = 'all';

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
        ]);
    }
}
