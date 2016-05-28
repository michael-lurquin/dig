<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Behaviour\ListAvailability;

class HomeController extends Controller
{
    use ListAvailability;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['welcome']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicesCount = \App\Service::count();
        $usersCount = \App\User::count();
        $availabilitiesCount = \App\Availability::count();
        $categoriesCount = \App\Category::count();

        return view('home')->withServices($servicesCount)->withUsers($usersCount)->withAvailabilities($availabilitiesCount)->withCategories($categoriesCount);
    }

    public function welcome()
    {
        $availabilities = array_flip($this->getListAvailability());
        $services = \App\Service::where('availability_id', $availabilities['Disponible'])->get();

        return view('welcome')->withServices($services);
    }
}
