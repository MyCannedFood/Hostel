<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHostelInfoRequest;
use App\Http\Requests\UpdateOperationalPoliciesRequest;
use App\Models\GeneralSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class GeneralSettingsController extends Controller
{
    public function updateHostelInformation(UpdateHostelInfoRequest $request): RedirectResponse
    {
        $setting = GeneralSetting::firstOrNew(['section' => 'hostel_info']);
        $data    = array_merge(GeneralSetting::DEFAULTS['hostel_info'], $setting->data ?? []);

        $data['hostel_name']       = $request->hostel_name;
        $data['default_language']  = $request->default_language;
        $data['currency']          = $request->currency;
        $data['timezone']          = $request->timezone;
        $data['site_title']        = $request->site_title;
        $data['meta_description']  = $request->meta_description;
        $data['languages']         = $request->input('languages', $data['languages']);

        if ($request->hasFile('main_logo')) {
            if (!empty($data['main_logo'])) Storage::disk('public')->delete($data['main_logo']);
            $data['main_logo'] = $request->file('main_logo')->store('general/hostel-info', 'public');
        }

        if ($request->hasFile('favicon')) {
            if (!empty($data['favicon'])) Storage::disk('public')->delete($data['favicon']);
            $data['favicon'] = $request->file('favicon')->store('general/hostel-info', 'public');
        }

        $setting->data       = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'general', 'sub' => 'hostel-info'])
            ->with('success', 'Hostel information saved.');
    }

    public function updateOperationalPolicies(UpdateOperationalPoliciesRequest $request): RedirectResponse
    {
        $setting = GeneralSetting::firstOrNew(['section' => 'operational_policies']);
        $data    = array_merge(GeneralSetting::DEFAULTS['operational_policies'], $setting->data ?? []);

        $data['checkin_time']    = $request->checkin_time;
        $data['checkout_time']   = $request->checkout_time;
        $data['late_policy']     = $request->late_policy;
        $data['tax_included']    = $request->boolean('tax_included');
        $data['government_tax']  = $request->government_tax;
        $data['service_charge']  = $request->service_charge;
        $data['house_rules']     = $request->house_rules;

        $setting->data       = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'general', 'sub' => 'operational-policies'])
            ->with('success', 'Operational policies saved.');
    }
}
