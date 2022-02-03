<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
// step 1 importazione modello
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //blog array
        $categories = ['HTML', 'CSS', 'PHP', 'JAVASCRIPT'];

        foreach ($categories as $category) {
            // step 2 nuova variabile
            $new_category = new Category;

            $new_category->name = $category;
            $new_category->slug = Str::slug($new_category->name, '-');

            $new_category->save();
        }
    }
}
