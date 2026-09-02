<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Angels Avvis Long No. 1', 'category' => 'Braids', 'buying_price' => 64, 'selling_price' => 80, 'stock_quantity' => 200, 'low_stock_threshold' => 30],
            ['name' => 'Angels Avvis Short No. 1', 'category' => 'Braids', 'buying_price' => 64, 'selling_price' => 80, 'stock_quantity' => 50, 'low_stock_threshold' => 10],
            ['name' => 'Jibambe Long No. 1', 'category' => 'Braids', 'buying_price' => 55, 'selling_price' => 70, 'stock_quantity' => 60, 'low_stock_threshold' => 10],
            ['name' => 'Jibambe Short No. 1', 'category' => 'Braids', 'buying_price' => 55, 'selling_price' => 70, 'stock_quantity' => 30, 'low_stock_threshold' => 8],
            ['name' => 'Lush Makeba Long No. 1', 'category' => 'Braids', 'buying_price' => 57, 'selling_price' => 75, 'stock_quantity' => 200, 'low_stock_threshold' => 30],
            ['name' => 'Lush Makeba Short No. 1', 'category' => 'Braids', 'buying_price' => 57, 'selling_price' => 75, 'stock_quantity' => 50, 'low_stock_threshold' => 10],
            ['name' => 'Emma Weave No. 1/350', 'category' => 'Weaves', 'buying_price' => 620, 'selling_price' => 680, 'stock_quantity' => 2, 'low_stock_threshold' => 3],
            ['name' => 'Afrobaby No. 1', 'category' => 'Weaves', 'buying_price' => 565, 'selling_price' => 650, 'stock_quantity' => 2, 'low_stock_threshold' => 3],
            ['name' => 'Adara No. 1', 'category' => 'Weaves', 'buying_price' => 565, 'selling_price' => 680, 'stock_quantity' => 2, 'low_stock_threshold' => 3],
            ['name' => 'Afro Twist Bulk No. 1', 'category' => 'Weaves', 'buying_price' => 435, 'selling_price' => 520, 'stock_quantity' => 6, 'low_stock_threshold' => 4],
            ['name' => 'Fluffy Kinky No. 2', 'category' => 'Weaves', 'buying_price' => 330, 'selling_price' => 380, 'stock_quantity' => 4, 'low_stock_threshold' => 3],
            ['name' => 'Ponytail No. 1', 'category' => 'Weaves', 'buying_price' => 166, 'selling_price' => 220, 'stock_quantity' => 4, 'low_stock_threshold' => 3],
            ['name' => 'Guess Gal No. 1', 'category' => 'Weaves', 'buying_price' => 355, 'selling_price' => 400, 'stock_quantity' => 4, 'low_stock_threshold' => 3],
            ['name' => 'Havana Curl No. 1', 'category' => 'Weaves', 'buying_price' => 445, 'selling_price' => 500, 'stock_quantity' => 4, 'low_stock_threshold' => 3],
            ['name' => 'Natural Locs No. 1', 'category' => 'Weaves', 'buying_price' => 500, 'selling_price' => 560, 'stock_quantity' => 4, 'low_stock_threshold' => 3],
            ['name' => 'Lioness Kinky No. 1', 'category' => 'Weaves', 'buying_price' => 330, 'selling_price' => 380, 'stock_quantity' => 4, 'low_stock_threshold' => 3],
            ['name' => 'Babylove Antidandruff 500g', 'category' => 'Hair Care', 'buying_price' => 255, 'selling_price' => 300, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Babylove Special Base 500g', 'category' => 'Hair Care', 'buying_price' => 230, 'selling_price' => 300, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Babylove Hairfood 500g', 'category' => 'Hair Care', 'buying_price' => 240, 'selling_price' => 280, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Bamsi Crystal Shampoo 250ml', 'category' => 'Hair Care', 'buying_price' => 46, 'selling_price' => 70, 'stock_quantity' => 12, 'low_stock_threshold' => 5],
            ['name' => 'Bamsi Conditioner White 250ml', 'category' => 'Hair Care', 'buying_price' => 55, 'selling_price' => 80, 'stock_quantity' => 12, 'low_stock_threshold' => 5],
            ['name' => 'Bamsi Moulding Wax 140g', 'category' => 'Hair Care', 'buying_price' => 220, 'selling_price' => 280, 'stock_quantity' => 6, 'low_stock_threshold' => 4],
            ['name' => 'Movit Curl Activator 360g', 'category' => 'Hair Care', 'buying_price' => 195, 'selling_price' => 230, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Movit Herbal Jelly 425ml', 'category' => 'Hair Care', 'buying_price' => 420, 'selling_price' => 450, 'stock_quantity' => 2, 'low_stock_threshold' => 3],
            ['name' => 'Movit Relaxer Super 150g', 'category' => 'Hair Care', 'buying_price' => 120, 'selling_price' => 170, 'stock_quantity' => 4, 'low_stock_threshold' => 3],
            ['name' => 'Radiant Antidandruff Cream 170g', 'category' => 'Hair Care', 'buying_price' => 161, 'selling_price' => 250, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'TCB Relaxer Super 500ml', 'category' => 'Hair Care', 'buying_price' => 353, 'selling_price' => 450, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Venus Curl Activator 210ml', 'category' => 'Hair Care', 'buying_price' => 205, 'selling_price' => 270, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Mega Growth Super 1-T-Up', 'category' => 'Hair Care', 'buying_price' => 372, 'selling_price' => 450, 'stock_quantity' => 2, 'low_stock_threshold' => 3],
            ['name' => 'Eco Gel Olive 236ml', 'category' => 'Hair Care', 'buying_price' => 270, 'selling_price' => 350, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Sedoso Styling Gel 80g Medium Hold', 'category' => 'Hair Care', 'buying_price' => 79, 'selling_price' => 130, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Nice and Lovely Hairfood Almond 100ml', 'category' => 'Skin Care', 'buying_price' => 155, 'selling_price' => 180, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Nice and Lovely Lotion Cocoabutter 400ml', 'category' => 'Skin Care', 'buying_price' => 250, 'selling_price' => 290, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Amara Lotion 400ml Raw Shea', 'category' => 'Skin Care', 'buying_price' => 214, 'selling_price' => 250, 'stock_quantity' => 3, 'low_stock_threshold' => 3],
            ['name' => 'Vaseline Original 100gms', 'category' => 'Skin Care', 'buying_price' => 125, 'selling_price' => 140, 'stock_quantity' => 4, 'low_stock_threshold' => 3],
            ['name' => 'Coconut Oil Sultan 150ml', 'category' => 'Skin Care', 'buying_price' => 70, 'selling_price' => 120, 'stock_quantity' => 6, 'low_stock_threshold' => 4],
            ['name' => 'Rexona Roll On 25ml Assorted', 'category' => 'Skin Care', 'buying_price' => 155, 'selling_price' => 200, 'stock_quantity' => 36, 'low_stock_threshold' => 10],
            ['name' => 'Body Splash 236ml', 'category' => 'Fragrance', 'buying_price' => 230, 'selling_price' => 280, 'stock_quantity' => 4, 'low_stock_threshold' => 3],
            ['name' => 'Subaru Black 64ml', 'category' => 'Nail Care', 'buying_price' => 50, 'selling_price' => 100, 'stock_quantity' => 10, 'low_stock_threshold' => 5],
            ['name' => 'Charmax Cutex Big', 'category' => 'Nail Care', 'buying_price' => 40, 'selling_price' => 60, 'stock_quantity' => 12, 'low_stock_threshold' => 5],
            ['name' => 'G-Nail Stick-ons', 'category' => 'Nail Care', 'buying_price' => 25, 'selling_price' => 50, 'stock_quantity' => 24, 'low_stock_threshold' => 8],
            ['name' => 'OPI Nail Polish', 'category' => 'Nail Care', 'buying_price' => 20, 'selling_price' => 50, 'stock_quantity' => 24, 'low_stock_threshold' => 8],
            ['name' => 'Mascara with Eyeliner', 'category' => 'Cosmetics', 'buying_price' => 50, 'selling_price' => 100, 'stock_quantity' => 6, 'low_stock_threshold' => 4],
            ['name' => 'Davis Eye Pencil Small', 'category' => 'Cosmetics', 'buying_price' => 20, 'selling_price' => 40, 'stock_quantity' => 48, 'low_stock_threshold' => 15],
            ['name' => 'Engagement Rings (Silver and Gold)', 'category' => 'Accessories', 'buying_price' => 100, 'selling_price' => 250, 'stock_quantity' => 100, 'low_stock_threshold' => 20],
            ['name' => 'Cocktail Rings', 'category' => 'Accessories', 'buying_price' => 60, 'selling_price' => 150, 'stock_quantity' => 100, 'low_stock_threshold' => 20],
            ['name' => 'Nose Rings Studs', 'category' => 'Accessories', 'buying_price' => 20, 'selling_price' => 50, 'stock_quantity' => 60, 'low_stock_threshold' => 15],
            ['name' => 'Afro Combs Big', 'category' => 'Accessories', 'buying_price' => 15, 'selling_price' => 50, 'stock_quantity' => 12, 'low_stock_threshold' => 5],
            ['name' => 'Wig Caps Brown/Black', 'category' => 'Accessories', 'buying_price' => 20, 'selling_price' => 50, 'stock_quantity' => 24, 'low_stock_threshold' => 8],
            ['name' => 'Beads Ceramic', 'category' => 'Accessories', 'buying_price' => 1, 'selling_price' => 5, 'stock_quantity' => 200, 'low_stock_threshold' => 40],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}