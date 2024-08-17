<?php

use App\Models\Catalogue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProductTableMigrations extends Migration
{
    public function up()
    {
        // Connect to remote database
        DB::connection('remote_mysql')->table('product')->orderBy('id')->chunk(1000, function ($products) {
            foreach ($products as $product) {
                // Create a new model instance
                $localCatalogue = new Catalogue();
                $localCatalogue->id = (int) $product->id;
                $localCatalogue->name = $product->productName;
                $localCatalogue->description = $product->productDescription;
                $localCatalogue->status = $product->productStatus == 1 ? 'active' : 'inactive';
                $localCatalogue->save();
            }
        });
    }

    public function down()
    {
        // Revert the migration (optional)
    }
}
