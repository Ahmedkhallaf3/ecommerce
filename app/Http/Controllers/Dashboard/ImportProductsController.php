<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;

class ImportProductsController extends Controller
{

    public function create()
    {
        return view('dashboard.product.import');
    }

    public function store(Request $request)
    {
        $job = new ImportProducts($request->post('count'));
        $job->onQueue('import')->delay(now()->addSeconds(5));
        dispatch($job);

        return redirect()
            ->route('product.index')
            ->with('success', 'Import is runing...');
    }
}
