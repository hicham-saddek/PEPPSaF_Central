<?php

namespace App\Http\Controllers;

use App\Models\Data;

class CalculatedDataController extends Controller
{
    protected string $orderBy = "desc";
    protected array $important_fields = [
            "identifier", "namespace", "value", "hostname", 
            "arrived_at", "sent_at", "received_at", "over", "name"
        ];

    protected int $max_life = 1;

    public function seen(){
        $this->destroy();
        $data = Data::orderBy("id", $this->orderBy)->where("seen", true)->get($this->important_fields)
        ->where("protocolDelay", '!=', 0);
        return response()->json(compact('data'));
    }

    public function unseen(){
        $this->destroy();
        $data = Data::orderBy("id", $this->orderBy)->where("seen", false)->paginate(15, $this->important_fields)
        ->where("protocolDelay", '!=', 0);
        $data->each(fn(Data $data) => $data->markAsSeen()->save());
        return response()->json(compact('data'));
    }

    public function destroy(): bool
    {
        Data::query()->where("received_at", '<=', now()->subMinutes($this->max_life))->delete();
        return true;
    }
}