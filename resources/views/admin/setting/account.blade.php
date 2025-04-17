@extends('layouts.admin')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Settings /</span> Account</h4>

    <div class="row">
      <div class="col-md-12">

        @include('admin/setting/tab_menu')
        
        <div class="card mb-4">
          <h5 class="card-header">Profile Details</h5>
          <!-- Account -->
          <form id="accountSettingsForm" method="POST" action="{{ route('admin.setting.save') }}" enctype="multipart/form-data">
            <input type="hidden" name="form_name" value="account">
            <input type="hidden" name="country_code" value="{{ setting('country_code') }}">
            @csrf
          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              <img
                src="{{ auth()->user()->profile_url }}"
                alt="user-avatar"
                class="d-block rounded"
                height="100"
                width="100"
                id="uploadedAvatar"
              />
              <div class="button-wrapper">
                <label for="profile_image" class="btn btn-primary me-2 mb-4" tabindex="0">
                  <span class="d-none d-sm-block">Upload new photo</span>
                  <i class="bx bx-upload d-block d-sm-none"></i>
                  <input type="file" id="profile_image" name="profile_image" class="account-file-input" hidden accept="image/png, image/jpeg"/>
                </label>
                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 2MB</p>
              </div>
            </div>
          </div>
          <hr class="my-0" />
          <div class="card-body">
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="firstName" class="form-label">First Name</label>
                <input class="form-control" type="text" id="firstName" name="first_name" value="{{ auth()->user()->first_name }}"/>
              </div>
              <div class="mb-3 col-md-6">
                <label for="lastName" class="form-label">Last Name</label>
                <input class="form-control" type="text" name="last_name" id="lastName" value="{{ auth()->user()->last_name }}"/>
              </div>
              <div class="mb-3 col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input class="form-control" type="text" id="email" name="email" value="{{ auth()->user()->email }}" placeholder="john.doe@example.com"/>
              </div>
              <!-- <div class="mb-3 col-md-6">
                <label for="organization" class="form-label">Organization</label>
                <input
                  type="text"
                  class="form-control"
                  id="organization"
                  name="organization"
                  value="ThemeSelection"
                />
              </div> -->
              <div class="mb-3 col-md-6">
                <label class="form-label" for="mobile">Mobile Number</label>
                <div class="input-group input-group-merge">
                  <span class="input-group-text">{{ setting('currency_code') }} (+{{ setting('country_code') }})</span>
                  <input type="text" id="mobile" name="mobile" class="form-control" placeholder="xxxx-xxx-xxx" value="{{ auth()->user()->mobile }}"/>
                </div>
              </div>
              <div class="mb-3 col-md-6">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" placeholder="Address">{{ auth()->user()->address }}</textarea>
              </div>
              <!-- <div class="mb-3 col-md-6">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Address" value="{{ auth()->user()->location }}"/>
              </div> -->
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2" id="submit-btn">Save changes</button>
              <button type="reset" class="btn btn-outline-secondary">Cancel</button>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script type="text/javascript">
    var profile_img = "{{ auth()->user()->profile_image }}";
    $(document).ready(function() {

      $('#address').summernote();

        $("#accountSettingsForm").validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 3
                },
                last_name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true
                },
                mobile: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                location: {
                    required: true,
                    minlength: 3,
                    maxlength: 3
                },
                address: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                first_name: {
                    required: "Please enter your first name",
                    minlength: "Your username must be at least 3 characters long"
                },
                last_name: {
                    required: "Please enter your last name",
                    minlength: "Your username must be at least 3 characters long"
                },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                mobile: {
                    required: "Please enter your mobile number",
                    digits: "Please enter only numbers",
                    minlength: "Mobile number must be exactly 10 digits",
                    maxlength: "Mobile number must be exactly 10 digits"
                },
                location: {
                    required: "Please enter your location",
                    minlength: "Location must be exactly 3 digits",
                    maxlength: "Location must be exactly 3 digits"
                },
                address: {
                    required: "Please enter your address",
                    minlength: "Address must be at least 5 characters long"
                }
            },
            submitHandler: function (form) {
                $('#submit-btn').prop("disabled", true);
                $('#submit-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                form.submit();
            }
        });

        $('#profile_image').on('change', function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#uploadedAvatar').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#uploadedAvatar').attr('src', profile_img);
            }
        });

    });
</script>
@endpush