<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\PosSetting;
use App\Models\Timezone;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VendorPosSettingController extends Controller
{
    public function index()
    {
        $vendorId = Auth::id();

        $setting = PosSetting::firstOrNew(
            ['vendor_id' => $vendorId],
            [
                'currency' => '₹',
                'timezone' => 'Asia/Kolkata',
                'default_customer_name' => 'Walk-in Customer',
                'default_contact_number' => '',
            ]
        );

        $timezones = Timezone::query()
            ->where('status', '1')
            ->orderBy('timezone')
            ->get(['timezone', 'description']);

        return view('vendor.pos.settings', [
            'setting' => $setting,
            'timezones' => $timezones,
        ]);
    }

    public function store(Request $request)
    {
        $vendorId = Auth::id();

        $validator = Validator::make($request->all(), [
            'invoice_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'currency' => ['required', 'string', 'max:10'],
            'timezone' => ['required', 'string', Rule::exists('timezones', 'timezone')->where(fn ($query) => $query->where('status', '1'))],
            'default_customer_name' => ['required', 'string', 'max:255'],
            'default_contact_number' => ['nullable', 'string', 'max:30'],
            'remove_invoice_logo' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $setting = PosSetting::firstOrNew(['vendor_id' => $vendorId]);

        $setting->currency = trim($request->input('currency', '₹')) ?: '₹';
        $setting->timezone = $request->input('timezone', 'Asia/Kolkata');
        $setting->default_customer_name = trim($request->input('default_customer_name', 'Walk-in Customer')) ?: 'Walk-in Customer';
        $setting->default_contact_number = trim($request->input('default_contact_number')) ?: null;

        $shouldRemoveLogo = $request->boolean('remove_invoice_logo');

        if ($shouldRemoveLogo && $setting->invoice_logo) {
            $this->deleteExistingLogo($setting->invoice_logo);
            $setting->invoice_logo = null;
        }

        if ($request->hasFile('invoice_logo')) {
            $this->deleteExistingLogo($setting->invoice_logo);
            $setting->invoice_logo = $this->storeInvoiceLogo($request->file('invoice_logo'), $vendorId);
        }

        $setting->vendor_id = $vendorId;
        $setting->save();

        return redirect()
            ->route('vendor.pos.settings.index')
            ->with('success', 'POS settings saved successfully.');
    }

    protected function storeInvoiceLogo(UploadedFile $file, int $vendorId): string
    {
        $directory = public_path('uploads/pos_settings/' . $vendorId);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = $file->getClientOriginalExtension();
        $filename = 'pos_logo_' . time() . '.' . $extension;
        $file->move($directory, $filename);

        return 'uploads/pos_settings/' . $vendorId . '/' . $filename;
    }

    protected function deleteExistingLogo(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
