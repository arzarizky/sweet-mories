<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserManager\StoreRequest as UserStore;
use App\Http\Requests\UserManager\UpdateRequest as UserUpdate;
use App\Interfaces\UserManagerRepositoryInterface;
use App\Interfaces\PromoRepositoryInterface;
use Illuminate\Support\Arr;

class UserManagerController extends Controller
{
    protected $userManagerRepository;
    protected $promoRepository;

    public function __construct(UserManagerRepositoryInterface $userManagerRepository, PromoRepositoryInterface $promoRepository)
    {
        $this->userManagerRepository = $userManagerRepository;
        $this->promoRepository = $promoRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $users = $this->userManagerRepository->getAll($search, $perPage);
        $promos = $this->promoRepository->getAll("ENABLE", $perPage);

        if ($users->isEmpty() && $page > 1) {
            return redirect()->route('user-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        // Pass parameters to the view
        return view('pages.user-manager.index', compact('users', 'promos', 'search', 'perPage', 'page'));
    }

    public function store(UserStore $request)
    {
        $this->userManagerRepository->create($request->all());

        return redirect()->back()->with('success', 'Admin '.$request->name.' berhasil dibuat');
    }

    public function update(UserUpdate $request, $id)
    {
        $newDetails = Arr::except($request->all(),['_token', '_method']);
        $this->userManagerRepository->update($id, $newDetails);

        return redirect()->back()->with('success', $request->name.' berhasil diubah');
    }

    public function updatePassword(UserUpdate $request, $id)
    {
        $newDetails = Arr::except($request->all(),['_token', '_method']);
        $this->userManagerRepository->updatePassword($id, $newDetails);

        return redirect()->back()->with('success',  'Password '.$request->name.' berhasil diubah');
    }

    public function destroy(Request $request, $id)
    {
        $this->userManagerRepository->delete($id);
        return redirect()->back()->with('success',  $request->name.' berhasil dihapus');
    }
}
