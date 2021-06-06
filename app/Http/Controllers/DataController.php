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
        return response()->json(Data::paginate(5, ["identifier", "namespace", "value", "hostname", "arrived_at", "sent_at", "received_at"]));
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

//	return response()->json(['what' => $data]);
        $data = json_decode($data, true);
	$data['received_at'] = now();
        return response()->json(['data' => Data::create($data)->toArray()]);
    }

    /**
     * Deletes all records that are received 10 minutes ago
     *
     * @return bool
     */
    public function destroy(): bool
    {
        Data::query()->where("received_at", '<=', now()->subMinutes(10))->delete();
        return true;
    }
}
