<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\UserManagerRepositoryInterface;

class DashboardController extends Controller
{
    protected $userManagerRepository;

    public function __construct(UserManagerRepositoryInterface $userManagerRepository)
    {
        $this->userManagerRepository = $userManagerRepository;
    }

    public function index()
    {
        $totalUserAdmin = $this->userManagerRepository->getTotalUser()['totalUserAdmin'];
        $totalUserClient = $this->userManagerRepository->getTotalUser()['totalUserClient'];

        return view('pages.dashboard.index', compact(
            'totalUserClient',
            'totalUserAdmin'
        ));
    }
}
