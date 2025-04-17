@extends('layouts.admin')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Settings /</span> Site
    </h4>

    <div class="row">
      <div class="col-md-12">
        
        @include('admin/setting/tab_menu')
        
          <div class="card">
            <h5 class="card-header">Site Settings</h5>
            <div class="card-body">
              <form id="siteForm" method="POST" action="{{ route('admin.setting.save') }}" enctype="multipart/form-data">
                <input type="hidden" name="form_name" value="site">
                @csrf
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                  <img
                    src="{{ !blank(setting('site_logo')) ? \Storage::url(setting('site_logo')) : asset('site/assets/images/logo.png') }}"
                    alt="user-avatar"
                    class="d-block rounded"
                    height="100"
                    width="200"
                    id="uploadedLogo"
                  />
                  <div class="button-wrapper">
                    <label for="site_logo" class="btn btn-primary me-2 mb-4" tabindex="0">
                      <span class="d-none d-sm-block">Upload new logo</span>
                      <i class="bx bx-upload d-block d-sm-none"></i>
                      <input type="file" id="site_logo" name="site_logo" class="account-file-input" hidden accept="image/png, image/jpeg"/>
                    </label>
                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 2MB</p>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-6 mb-3">
                    <label for="site_name" class="form-label">Site Name</label>
                    <input type="text" name="site_name" id="site_name" class="form-control" value="{{ setting('site_name', '') }}" placeholder="{{ config('app.name') }}" />
                  </div>
                  <div class="col-6 mb-3">
                    <label for="report_email" class="form-label">Report Email</label>
                    <input type="text" name="report_email" id="report_email" class="form-control" value="{{ setting('report_email', '') }}" placeholder="xxxx@xxxx.xxx" />
                  </div>
                  <div class="col-6 mb-3">
                    <label for="email_driver" class="form-label">Email Driver</label>
                    <input type="text" name="email_driver" id="email_driver" class="form-control" value="{{ setting('email_driver', '') }}" placeholder="smtp" />
                  </div>
                  <div class="col-6 mb-3">
                    <label for="email_host" class="form-label">Email Host</label>
                    <input type="text" name="email_host" id="email_host" class="form-control" value="{{ setting('email_host', '') }}" placeholder="smtp.gmail.com" />
                  </div>
                  <div class="col-6 mb-3">
                    <label for="email_port" class="form-label">Email Port</label>
                    <input type="text" name="email_port" id="email_port" class="form-control" value="{{ setting('email_port', '') }}" placeholder="465" />
                  </div>
                  <div class="col-6 mb-3">
                    <label for="email_encryption" class="form-label">Email Encryption</label>
                    <input type="text" name="email_encryption" id="email_encryption" class="form-control" value="{{ setting('email_encryption', '') }}" placeholder="ssl" />
                  </div>
                  <div class="col-6 mb-3">
                    <label for="email_username" class="form-label">Email Username</label>
                    <input type="text" name="email_username" id="email_username" class="form-control" value="{{ setting('email_username', '') }}" placeholder="xxx@xxx.xxx" />
                  </div>
                  <div class="col-6 mb-3">
                    <label for="email_password" class="form-label">Email Password</label>
                    <input type="password" name="email_password" id="email_password" class="form-control" value="{{ setting('email_password', '') }}" placeholder="******" />
                  </div>
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
    var site_logo = "{{ !blank(setting('site_logo')) ? \Storage::url(setting('site_logo')) : asset('site/assets/images/logo.png') }}";

    $(document).ready(function() {

        $("#siteForm").validate({
            rules: {
                site_name: {
                    required: true,
                }
            },
            messages: {
                site_name: {
                    required: "Please enter site name",
                }
            },
            submitHandler: function (form) {
                $('#submit-btn').prop("disabled", true);
                $('#submit-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                form.submit();
            }
        });

        $('#site_logo').on('change', function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#uploadedLogo').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#uploadedLogo').attr('src', site_logo);
            }
        });
    });
</script>
@endpush