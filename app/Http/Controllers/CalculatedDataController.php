<?php

namespace App\Http\Controllers;

use App\Models\Data;

class CalculatedDataController extends Controller{
    
    public function all(){
        $this->destroy();
        $data = Data::all()->where("protocolDelay", '!=', 0);
        return response()->json(compact('data'));
    }

    public function seen(){
        $this->destroy();
        $data = Data::where("seen", true)->get($this->important_fields)
        ->where("protocolDelay", '!=', 0);
        return response()->json(compact('data'));
    }

    public function unseen(){
        $this->destroy();
        $data = Data::where("seen", false)->paginate(15, $this->important_fields)
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