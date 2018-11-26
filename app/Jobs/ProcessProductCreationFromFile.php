<?php

namespace App\Jobs;

use App\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\Product\StoreRules;
use Illuminate\Support\Facades\Validator;
use App\Helpers\SampleStandards;

class ProcessProductCreationFromFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProductService $productService)
    {
        $files = Storage::disk('productBulk')->files();

        foreach ($files as $item) {
            $file = fopen(Storage::disk('productBulk')->path($item), 'r');
            $i = 0;

            while (($line = fgetcsv($file)) !== false) {
                if ($i === 0) {
                    $headerCorrect = true;
                    foreach ($line as $key => $column) {
                        if (!($column === SampleStandards::PRODUCT_CREATE_BULK[$key])) {
                            $headerCorrect = false;
                            break;
                        }
                    }

                    if (!$headerCorrect) {
                        break;
                        // todo delete file inform that file structure is not correct use sample.
                    }
                } else {
                    $structured = $productService->getCSVStandardStructure($line);
                    $validator = Validator::make($structured, StoreRules::getStandardRules());
                    if ($validator->errors()->count()) {
                        // todo add log, inform in email that not all data was proceeded, as were validation errors
                        continue;
                    } else {
                        $productService->store($structured);
                    }
                }

                $i++;
            }

            Storage::disk('productBulk')->delete($item);

            // todo send email
            fclose($file);
        }
    }
}
