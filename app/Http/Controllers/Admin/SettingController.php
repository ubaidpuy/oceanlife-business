<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(private ImageUploadService $imageUpload) {}

    public function edit(): View
    {
        $settings = Setting::instance();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(SettingRequest $request): RedirectResponse
    {
        $settings = Setting::instance();
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $this->imageUpload->delete($settings->logo);
            $data['logo'] = $this->imageUpload->upload($request->file('logo'), 'settings');
        }

        $settings->update($data);

        return back()->with('success', 'Settings updated successfully.');
    }
}
