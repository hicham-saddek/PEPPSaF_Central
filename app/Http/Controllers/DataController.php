<?php


namespace App\Http\Controllers;


use App\Models\Data;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * @return Data[]|Collection
     */
    public function index()
    {
        return Data::all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'data' => ['array', 'required']
        ])["data"];
        $data['received_at'] = now();
        return Data::create($data);
    }

    /**
     * Deletes all records that are received 10 minutes ago
     *
     * @return bool
     */
    public function destroy(): bool
    {
        Data::query()->where("received_at", now()->subMinutes(10))->delete();
        return true;
    }
}
