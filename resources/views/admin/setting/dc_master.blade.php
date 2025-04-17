@extends('layouts.admin')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Settings /</span> DC Master
    </h4>

    <div class="row">
      <div class="col-md-12">
        
        @include('admin/setting/tab_menu')
        
          <div class="card">
            <h5 class="card-header">DC No Format</h5>
            <div class="card-body">
              <div class="mb-3 col-12 mb-0">
                <div class="alert alert-warning">
                  <h6 class="alert-heading fw-bold mb-1">24-25/CHY/DC/133</h6>
                  <p class="mb-0">Financial year will be automatically will change, CHY will the the from location area, DC is static, 133 is running number</p>
                </div>
              </div>
              <form id="dcMasterForm" method="POST" action="{{ route('admin.setting.save') }}">
                <input type="hidden" name="form_name" value="dc_master">
                @csrf
                <div class="col mb-3">
                  <label for="pl_start_no" class="form-label">Running number start Point</label>
                  <input type="text" name="pl_start_no" id="pl_start_no" class="form-control" value="{{ setting('pl_start_no', '') }}" placeholder="Eg: 133" />
                </div>
                <button type="submit" class="btn btn-danger deactivate-account" id="submit-btn">Save</button>
              </form>
            </div>
          </div>
          <!-- /Notifications -->
      </div>
    </div>
  </div>
  <!-- / Content -->


  <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $("#dcMasterForm").validate({
            rules: {
                pl_start_no: {
                    required: true,
                    digits: true,
                    minlength: 1,
                    maxlength: 7
                }
            },
            messages: {
                pl_start_no: {
                    required: "Please enter pl start number",
                    digits: "Please enter only numbers",
                    minlength: "The number must be atleast 1 digit",
                    maxlength: "The number should be maximum 7 digits"
                }
            },
            submitHandler: function (form) {
                $('#submit-btn').prop("disabled", true);
                $('#submit-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                form.submit();
            }
        });
    });
</script>
@endpush