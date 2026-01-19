<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MissionCompanionService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MissionCompanionController extends Controller
{
    protected MissionCompanionService $missionCompanionService;

    public function __construct(MissionCompanionService $missionCompanionService)
    {
        $this->missionCompanionService = $missionCompanionService;
    }

    public function index()
    {
        $companions = $this->missionCompanionService->getAllMissionCompanions();

        return view('admin.mission_companions.index', [
            'companions' => $companions,
        ]);
    }

    public function create()
    {
        return view('admin.mission_companions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name_fr' => 'nullable|string',
            'last_name_fr' => 'nullable|string',
            'first_name_ar' => 'nullable|string',
            'last_name_ar' => 'nullable|string',
            'cin' => 'nullable|string',
        ]);

        try {
            $this->missionCompanionService->createMissionCompanion($request);
            Alert::success('Success', 'Saved Correctly');
            return redirect()->route('admin.mission_companions.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
        }

        return back();
    }

    public function edit($id)
    {
        try {
            $companion = $this->missionCompanionService->getMissionCompanionById($id);

            if (!$companion) {
                Alert::error('Error', 'Companion not found');
                return redirect()->route('admin.mission_companions.index');
            }
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid companion ID');
            return redirect()->route('admin.mission_companions.index');
        }

        return view('admin.mission_companions.edit', [
            'companion' => $companion,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name_fr' => 'nullable|string',
            'last_name_fr' => 'nullable|string',
            'first_name_ar' => 'nullable|string',
            'last_name_ar' => 'nullable|string',
            'cin' => 'nullable|string',
        ]);

        try {
            $companion = $this->missionCompanionService->getMissionCompanionById($id);

            if (!$companion) {
                Alert::error('Error', 'Companion not found');
                return back();
            }

            $this->missionCompanionService->updateMissionCompanion($companion, $request);
            Alert::success('Success', 'Saved Correctly');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid companion ID');
        }

        return back();
    }

    public function destroy($id)
    {
        try {
            $companion = $this->missionCompanionService->getMissionCompanionById($id);

            if (!$companion) {
                Alert::error('Error', 'Companion not found');
                return redirect()->route('admin.mission_companions.index');
            }

            $this->missionCompanionService->deleteMissionCompanion($companion);
            Alert::success('Success', 'Deleted');
        } catch (\Throwable $th) {
            Alert::error('Error', 'Invalid companion ID');
        }

        return redirect()->route('admin.mission_companions.index');
    }
}
