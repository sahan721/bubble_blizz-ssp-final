<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // =========================
            // FRUIT JUICES (10)
            // =========================
            ['id'=>1,  'name'=>'Orange Juice 300ml',      'category'=>'juices', 'description'=>'Fresh orange juice',           'price'=>280, 'stock'=>60,  'image'=>'https://via.placeholder.com/360x220?text=Orange+Juice'],
            ['id'=>2,  'name'=>'Mango Juice 300ml',       'category'=>'juices', 'description'=>'Sweet mango juice',            'price'=>300, 'stock'=>55,  'image'=>'https://via.placeholder.com/360x220?text=Mango+Juice'],
            ['id'=>3,  'name'=>'Pineapple Juice 300ml',   'category'=>'juices', 'description'=>'Tropical pineapple juice',     'price'=>290, 'stock'=>50,  'image'=>'https://via.placeholder.com/360x220?text=Pineapple+Juice'],
            ['id'=>4,  'name'=>'Mixed Fruit Juice 300ml', 'category'=>'juices', 'description'=>'Blend of mixed fruits',        'price'=>320, 'stock'=>45,  'image'=>'https://via.placeholder.com/360x220?text=Mixed+Fruit+Juice'],
            ['id'=>5,  'name'=>'Apple Juice 300ml',       'category'=>'juices', 'description'=>'Crisp apple juice',            'price'=>330, 'stock'=>40,  'image'=>'https://via.placeholder.com/360x220?text=Apple+Juice'],
            ['id'=>6,  'name'=>'Grape Juice 300ml',       'category'=>'juices', 'description'=>'Rich grape juice',             'price'=>340, 'stock'=>38,  'image'=>'https://via.placeholder.com/360x220?text=Grape+Juice'],
            ['id'=>7,  'name'=>'Watermelon Juice 300ml',  'category'=>'juices', 'description'=>'Refreshing watermelon juice',  'price'=>260, 'stock'=>42,  'image'=>'https://via.placeholder.com/360x220?text=Watermelon+Juice'],
            ['id'=>8,  'name'=>'Papaya Juice 300ml',      'category'=>'juices', 'description'=>'Smooth papaya juice',          'price'=>270, 'stock'=>35,  'image'=>'https://via.placeholder.com/360x220?text=Papaya+Juice'],
            ['id'=>9,  'name'=>'Lime Juice 300ml',        'category'=>'juices', 'description'=>'Zesty lime juice',             'price'=>220, 'stock'=>48,  'image'=>'https://via.placeholder.com/360x220?text=Lime+Juice'],
            ['id'=>10, 'name'=>'Woodapple Juice 300ml',   'category'=>'juices', 'description'=>'Traditional woodapple juice',  'price'=>350, 'stock'=>30,  'image'=>'https://via.placeholder.com/360x220?text=Woodapple+Juice'],

            // =========================
            // SOFT DRINKS (10)
            // =========================
            ['id'=>11, 'name'=>'Coca-Cola 330ml',         'category'=>'soft-drinks', 'description'=>'Classic cola drink',      'price'=>250, 'stock'=>90,  'image'=>'https://via.placeholder.com/360x220?text=Coca-Cola'],
            ['id'=>12, 'name'=>'Sprite 330ml',            'category'=>'soft-drinks', 'description'=>'Lemon-lime soda',         'price'=>240, 'stock'=>85,  'image'=>'https://via.placeholder.com/360x220?text=Sprite'],
            ['id'=>13, 'name'=>'Fanta Orange 330ml',      'category'=>'soft-drinks', 'description'=>'Orange flavored soda',    'price'=>240, 'stock'=>80,  'image'=>'https://via.placeholder.com/360x220?text=Fanta'],
            ['id'=>14, 'name'=>'7UP 330ml',               'category'=>'soft-drinks', 'description'=>'Clear lemon-lime soda',   'price'=>240, 'stock'=>110, 'image'=>'https://via.placeholder.com/360x220?text=7UP'],
            ['id'=>15, 'name'=>'Pepsi 330ml',             'category'=>'soft-drinks', 'description'=>'Cola soft drink',         'price'=>240, 'stock'=>75,  'image'=>'https://via.placeholder.com/360x220?text=Pepsi'],
            ['id'=>16, 'name'=>'Ginger Ale 330ml',        'category'=>'soft-drinks', 'description'=>'Ginger flavored soda',    'price'=>260, 'stock'=>55,  'image'=>'https://via.placeholder.com/360x220?text=Ginger+Ale'],
            ['id'=>17, 'name'=>'Tonic Water 330ml',       'category'=>'soft-drinks', 'description'=>'Bitter tonic water',      'price'=>260, 'stock'=>45,  'image'=>'https://via.placeholder.com/360x220?text=Tonic+Water'],
            ['id'=>18, 'name'=>'Soda Water 330ml',        'category'=>'soft-drinks', 'description'=>'Sparkling soda water',    'price'=>200, 'stock'=>50,  'image'=>'https://via.placeholder.com/360x220?text=Soda+Water'],
            ['id'=>19, 'name'=>'Cola Zero 330ml',         'category'=>'soft-drinks', 'description'=>'Zero sugar cola',         'price'=>270, 'stock'=>40,  'image'=>'https://via.placeholder.com/360x220?text=Cola+Zero'],
            ['id'=>20, 'name'=>'Cream Soda 330ml',        'category'=>'soft-drinks', 'description'=>'Sweet cream soda',        'price'=>230, 'stock'=>60,  'image'=>'https://via.placeholder.com/360x220?text=Cream+Soda'],

            // =========================
            // DAIRY DRINKS (10)
            // =========================
            ['id'=>21, 'name'=>'Chocolate Milk 250ml',    'category'=>'dairy', 'description'=>'Chocolate flavored milk',      'price'=>220, 'stock'=>40,  'image'=>'https://via.placeholder.com/360x220?text=Choco+Milk'],
            ['id'=>22, 'name'=>'Vanilla Milk 250ml',      'category'=>'dairy', 'description'=>'Vanilla flavored milk',        'price'=>220, 'stock'=>35,  'image'=>'https://via.placeholder.com/360x220?text=Vanilla+Milk'],
            ['id'=>23, 'name'=>'Strawberry Milk 250ml',   'category'=>'dairy', 'description'=>'Strawberry flavored milk',     'price'=>230, 'stock'=>35,  'image'=>'https://via.placeholder.com/360x220?text=Strawberry+Milk'],
            ['id'=>24, 'name'=>'Iced Coffee Milk 250ml',  'category'=>'dairy', 'description'=>'Coffee flavored milk drink',   'price'=>260, 'stock'=>30,  'image'=>'https://via.placeholder.com/360x220?text=Iced+Coffee'],
            ['id'=>25, 'name'=>'Malted Milk 250ml',       'category'=>'dairy', 'description'=>'Malted milk drink',            'price'=>240, 'stock'=>28,  'image'=>'https://via.placeholder.com/360x220?text=Malted+Milk'],
            ['id'=>26, 'name'=>'Yogurt Drink 200ml',      'category'=>'dairy', 'description'=>'Smooth yogurt drink',          'price'=>200, 'stock'=>50,  'image'=>'https://via.placeholder.com/360x220?text=Yogurt+Drink'],
            ['id'=>27, 'name'=>'Lassi 250ml',             'category'=>'dairy', 'description'=>'Sweet lassi drink',             'price'=>230, 'stock'=>25,  'image'=>'https://via.placeholder.com/360x220?text=Lassi'],
            ['id'=>28, 'name'=>'Buttermilk 250ml',        'category'=>'dairy', 'description'=>'Light salted buttermilk',      'price'=>180, 'stock'=>30,  'image'=>'https://via.placeholder.com/360x220?text=Buttermilk'],
            ['id'=>29, 'name'=>'Milkshake Chocolate 300ml','category'=>'dairy','description'=>'Creamy chocolate milkshake',    'price'=>350, 'stock'=>20,  'image'=>'https://via.placeholder.com/360x220?text=Milkshake'],
            ['id'=>30, 'name'=>'Milkshake Vanilla 300ml', 'category'=>'dairy', 'description'=>'Creamy vanilla milkshake',     'price'=>350, 'stock'=>20,  'image'=>'https://via.placeholder.com/360x220?text=Vanilla+Shake'],

            // =========================
            // ENERGY DRINKS (10)
            // =========================
            ['id'=>31, 'name'=>'Energy Blast 250ml',      'category'=>'energy-drinks', 'description'=>'Boost your energy',     'price'=>420, 'stock'=>30,  'image'=>'https://via.placeholder.com/360x220?text=Energy+Blast'],
            ['id'=>32, 'name'=>'Power Charge 250ml',      'category'=>'energy-drinks', 'description'=>'High caffeine energy',  'price'=>450, 'stock'=>28,  'image'=>'https://via.placeholder.com/360x220?text=Power+Charge'],
            ['id'=>33, 'name'=>'Turbo Rush 250ml',        'category'=>'energy-drinks', 'description'=>'Quick energy boost',    'price'=>430, 'stock'=>26,  'image'=>'https://via.placeholder.com/360x220?text=Turbo+Rush'],
            ['id'=>34, 'name'=>'Red Storm 250ml',         'category'=>'energy-drinks', 'description'=>'Energy + focus',        'price'=>480, 'stock'=>22,  'image'=>'https://via.placeholder.com/360x220?text=Red+Storm'],
            ['id'=>35, 'name'=>'Blue Spark 250ml',        'category'=>'energy-drinks', 'description'=>'Berry energy drink',    'price'=>460, 'stock'=>24,  'image'=>'https://via.placeholder.com/360x220?text=Blue+Spark'],
            ['id'=>36, 'name'=>'Green Kick 250ml',        'category'=>'energy-drinks', 'description'=>'Citrus energy drink',   'price'=>440, 'stock'=>20,  'image'=>'https://via.placeholder.com/360x220?text=Green+Kick'],
            ['id'=>37, 'name'=>'Ultra Energy 250ml',      'category'=>'energy-drinks', 'description'=>'Extra strength energy', 'price'=>520, 'stock'=>18,  'image'=>'https://via.placeholder.com/360x220?text=Ultra+Energy'],
            ['id'=>38, 'name'=>'Night Drive 250ml',       'category'=>'energy-drinks', 'description'=>'Stay alert longer',     'price'=>500, 'stock'=>16,  'image'=>'https://via.placeholder.com/360x220?text=Night+Drive'],
            ['id'=>39, 'name'=>'Volt Max 250ml',          'category'=>'energy-drinks', 'description'=>'Maximum performance',   'price'=>540, 'stock'=>14,  'image'=>'https://via.placeholder.com/360x220?text=Volt+Max'],
            ['id'=>40, 'name'=>'Swift Energy 250ml',      'category'=>'energy-drinks', 'description'=>'Smooth energy boost',   'price'=>410, 'stock'=>25,  'image'=>'https://via.placeholder.com/360x220?text=Swift+Energy'],
        ];

        Product::upsert(
            $rows,
            ['id'],
            ['name','category','description','price','stock','image','updated_at']
        );
    }
}
