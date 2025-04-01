<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use ImageOptimizer;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class BarcodeController extends Controller
{
    public function index(request $request) 
    {
        $product = Product::find($request->id);

        return view('barcode', [
            'product' => $product
        ]);
    }

    public function optimize(request $request){
        $details = ProductImage::select('image')->get();
        foreach($details as $detail){
            $optimizerChain = OptimizerChainFactory::create();
            $explode = explode("http://146.190.85.129",$detail->image);
            $pathToImage = $explode[1];

            $relativePathToImage = $pathToImage;
            $absolutePathToImage = realpath($_SERVER['DOCUMENT_ROOT'] . $relativePathToImage);

            // Ensure the path is correct
            if (!$absolutePathToImage || !file_exists($absolutePathToImage)) {
                die("File does not exist: " . $absolutePathToImage);
            }

            // Create the optimizer chain
            $optimizerChain = OptimizerChainFactory::create();

            // Optional: Debugging output
            echo "Optimizing Image Path: " . $absolutePathToImage . PHP_EOL;

            $optimizerChain->optimize($absolutePathToImage);
            // Optimize the image in place
        }
        return "Success";
    }
}