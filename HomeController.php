<?php

public function index() {
    return view('index');
}


public function loadData()
{
    $pageperrow = 100;
    $count = request('count');
    $skip = ($count - 1) * $pageperrow;
    $max_count = ceil(count(YourModel::get()) / $pageperrow);
    
    $infinite_data = YourModel::skip($skip)->take($pageperrow)->get();
    
    return response()->json(['infinite_data'=> $infinite_data, 'max_count' => $max_count]);
}