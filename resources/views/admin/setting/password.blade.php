@extends('layouts.admin')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Settings /</span> Password</h4>

    <div class="row">
      <div class="col-md-12">

        @include('admin/setting/tab_menu')

        <div class="card mb-4">
          <h5 class="card-header">Password Change</h5>
          <!-- Account -->
          <form id="passwordForm" method="POST" action="{{ route('admin.setting.save') }}">
            <input type="hidden" name="form_name" value="password">
            @csrf
          <div class="card-body">
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="old_password" class="form-label">Old Password</label>
                <input class="form-control" type="password" id="old_password" name="old_password"/>
              </div>
              <div class="mb-3 col-md-6">
              </div>
              <div class="mb-3 col-md-6">
                <label for="password" class="form-label">New Password</label>
                <input class="form-control" type="password" name="password" id="password"/>
              </div>
              <div class="mb-3 col-md-6">
              </div>
              <div class="mb-3 col-md-6">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input class="form-control" type="password" id="confirm_password" name="confirm_password"/>
              </div>
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2" id="submit-btn">Password Update</button>
            </div>
          </div>
          </form>
          <!-- /Account -->
        </div>
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
    var profile_img = "{{ auth()->user()->profile_image }}";
    $(document).ready(function() {

        $("#passwordForm").validate({
            rules: {
              old_password: {
                required: true
              },
              password: {
                required: true,
                minlength: 6
              },
              confirm_password: {
                required: true,
                equalTo: "#password"
              }
            },
            messages: {
              old_password: {
                required: "Please provide your old password"
              },
              password: {
                required: "Please provide your new password",
                minlength: "Your password must be at least 6 characters long"
              },
              confirm_password: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match"
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