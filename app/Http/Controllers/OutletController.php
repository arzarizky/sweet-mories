<?php

namespace App\Http\Controllers;

use App\Models\OutletSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Interfaces\OutletRepositoryInterface;

class OutletController extends Controller
{
    protected $outletRepository;

    public function __construct(OutletRepositoryInterface $outletRepository)
    {
        $this->outletRepository = $outletRepository;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $page = $request->input('page', 1);

        $datas = $this->outletRepository->getAll($search, $perPage);

        if ($datas->isEmpty() && $page > 1) {
            return redirect()->route('user-manager', [
                'search' => $search,
                'per_page' => $perPage,
                'page' => 1
            ]);
        }

        return view('pages.outlet-setting.index', compact('datas', 'search', 'perPage', 'page'));
    }

    public function createSettingOutlet(Request $request)
    {
        $createCloseOutlet = $this->outletRepository->create($request->all());

        if ($createCloseOutlet['status'] === 'success') {
            return redirect()->route('outlet')->with('success', $createCloseOutlet['message']);
        } else {
            return redirect()->route('outlet')->with('error', $createCloseOutlet['message']);
        }
    }

    public function updateOutletSetting(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateOutletSetting = $this->outletRepository->updateOutletSetting($id, $newDetails);
        if ($updateOutletSetting['status'] === 'success') {
            return redirect()->route('outlet')->with('success', $updateOutletSetting['message']);
        } else {
            return redirect()->route('outlet')->with('error', $updateOutletSetting['message']);
        }
    }

    public function editOutletSettingStatus(Request $request, $id)
    {
        $datas = $this->outletRepository->editOutletSettingStatus($id);
        return view('pages.outlet-setting.edit', compact('datas'));
    }

    public function updateOutletSettingStatus(Request $request, $id)
    {
        $newDetails = Arr::except($request->all(), ['_token', '_method']);
        $updateOutletSettingStatus = $this->outletRepository->updateOutletSettingStatus($id, $newDetails);
        if($updateOutletSettingStatus["status"] === "error") {
            return redirect()->back()->with('error',  $request->name . $updateOutletSettingStatus["message"]);

        }
        return redirect()->back()->with('success',  'Status ' . $request->name . ' berhasil diubah');
    }
}
