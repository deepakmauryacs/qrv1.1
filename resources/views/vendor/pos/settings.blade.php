@extends('vendor.layouts.default')

@section('pageTitle', 'POS Settings')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">POS Settings</h1>
        <a href="{{ route('vendor.pos.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back to POS
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">General</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('vendor.pos.settings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="invoice_logo">POS Logo for Invoice</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="invoice_logo" name="invoice_logo" accept="image/*">
                        <label class="custom-file-label" for="invoice_logo">Choose file</label>
                    </div>
                    <small class="form-text text-muted">Accepted formats: jpeg, png, jpg, gif, svg, webp (max 2 MB).</small>
                    @if(!empty($setting->invoice_logo))
                        <div class="mt-3 d-flex align-items-center">
                            <img src="{{ asset($setting->invoice_logo) }}" alt="POS logo" class="img-thumbnail mr-3" style="max-height: 80px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="remove_invoice_logo" name="remove_invoice_logo">
                                <label class="form-check-label" for="remove_invoice_logo">
                                    Remove current logo
                                </label>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="currency">Currency Symbol</label>
                        <input type="text" class="form-control" id="currency" name="currency" value="{{ old('currency', $setting->currency ?? '₹') }}" maxlength="10" required>
                        <small class="form-text text-muted">This symbol will be used across the POS and printed invoices.</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="timezone">Time Zone</label>
                        <select class="form-control" id="timezone" name="timezone" required>
                            @php($selectedTimezone = old('timezone', $setting->timezone ?? 'Asia/Kolkata'))
                            @forelse($timezones as $timezone)
                                <option value="{{ $timezone->timezone }}" {{ $selectedTimezone === $timezone->timezone ? 'selected' : '' }}>
                                    {{ $timezone->description }} ({{ $timezone->timezone }})
                                </option>
                            @empty
                                <option value="Asia/Kolkata" selected>Asia/Kolkata (Asia/Kolkata)</option>
                            @endforelse
                        </select>
                        <small class="form-text text-muted">Used to display order timestamps on the POS and receipts.</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="default_customer_name">Default Customer Name</label>
                        <input type="text" class="form-control" id="default_customer_name" name="default_customer_name" value="{{ old('default_customer_name', $setting->default_customer_name ?? 'Walk-in Customer') }}" maxlength="255" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="default_contact_number">Default Contact Number</label>
                        <input type="text" class="form-control" id="default_contact_number" name="default_contact_number" value="{{ old('default_contact_number', $setting->default_contact_number) }}" maxlength="30">
                        <small class="form-text text-muted">Optional. Leave blank if you prefer to enter the contact number manually.</small>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('.custom-file-input').on('change', function () {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName || 'Choose file');
        });
    });
</script>
@endpush

