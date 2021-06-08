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
        $this->destroy();
        $data = Data::where("seen", false)->get();
        $data->each(fn(Data $data) => $data->markAsSeen()->save());
        return response()->json(compact('data'));
        return Data::paginate();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'data' => ['required']
        ])["data"];
        $data = json_decode($data, true);
        return response()->json(['data' => Data::create($data)->toArray()]);
    }

    /**
     * Deletes all records that are received 10 minutes ago
     *
     * @return bool
     */
    public function destroy(): bool
    {
        Data::query()->where("received_at", '<=', now()->subMinutes(1))->delete();
        return true;
    }
}
