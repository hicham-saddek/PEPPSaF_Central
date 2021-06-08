<?php


namespace App\Http\Controllers;


use App\Models\Data;
use Illuminate\Http\Request;

class DataController extends Controller
{
    protected string $orderBy = "desc";
    protected array $important_fields = [
            "identifier", "namespace", "value", "hostname", 
            "arrived_at", "sent_at", "received_at", "over", "name"
        ];

    protected int $max_life = 1;

    public function unseen()
    {
        $this->destroy();
        $data = Data::orderBy("id", $this->orderBy)->where("seen", false)->get($this->important_fields);
        $data->each(fn(Data $data) => $data->markAsSeen()->save());
        return response()->json(compact('data'));
    }

    public function seen()
    {
        $this->destroy();
        $data = Data::orderBy("id", $this->orderBy)->where("seen", true)->get($this->important_fields);
        $data->each(fn(Data $data) => $data->markAsSeen()->save());
        return response()->json(compact('data'));
    }

    public function all()
    {
        $this->destroy();
        $data = Data::orderBy("id", $this->orderBy)->take(20)->get($this->important_fields);
        $data->each(fn(Data $data) => $data->markAsSeen()->save());
        return response()->json(compact('data'));
    }

    public function take(int $take = 1)
    {
        $this->destroy();
        $data = Data::orderBy("id", $this->orderBy)->where('seen', false)->take($take)->get($this->important_fields);
        $data->each(fn(Data $data) => $data->markAsSeen()->save());
        return response()->json(compact('data'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return response()->json(['data' => Data::create(json_decode($request->validate([
                'data' => ['required']
            ])["data"], true))->toArray()]);
    }

    /**
     * Deletes all records that are received 10 minutes ago
     *
     * @return bool
     */
    public function destroy(): bool
    {
        Data::query()->where("received_at", '<', now()->subMinutes($this->max_life))->delete();
        return true;
    }
}
