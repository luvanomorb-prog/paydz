<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\ApiKeyService;



class ApiKeyController extends Controller
{


public function index(
Request $request
)
{

$merchant =
$request->user()
->merchant;


$key =
$merchant
->apiKey;


return inertia(
'Settings/ApiKeys',
[
'apiKey'=>$key
]
);


}



public function regenerate(
Request $request,
ApiKeyService $service
)
{


$merchant =
$request->user()
->merchant;


$key =
$service->regenerate(
$merchant
);


return back();


}



}
