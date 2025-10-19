@extends('admin.layouts.default')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Edit Subscription</h1>
        <a href="{{ route('admin.subscriptions') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Subscription Details</h6>
        </div>
        <div class="card-body">
            <form id="subscriptionForm" action="{{ route('admin.subscriptions.update', $subscription->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="plan_name" class="form-label">Plan Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="plan_name" name="plan_name" value="{{ old('plan_name', $subscription->plan_name) }}" required />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" value="{{ old('amount', $subscription->amount) }}" required />
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1" {{ old('status', $subscription->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ old('status', $subscription->status) == 2 ? 'selected' : '' }}>Not Active</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Save Changes</button>
                </div>
            </form>  
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#subscriptionForm').submit(function(e) {
            e.preventDefault();

            var isValid = true;

            // Validation checks for required fields
            if ($('#plan_name').val() == '') {
                toastr.error("Please enter the subscription plan name.");
                isValid = false;
            }

            if ($('#amount').val() == '') {
                toastr.error("Please enter the amount.");
                isValid = false;
            }

            if (isValid) {
                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == 1) {
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.href = '{{ route('admin.subscriptions') }}';
                            }, 300);
                        } else {
                            $.each(response.message, function(index, error) {
                                toastr.error(error);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred: ' + error);
                    }
                });
            }
        });
    });
</script>

@endsection
