@extends('layouts.admin')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Customers</h4>
        <!-- Striped Rows -->
        <div class="ms-auto text-end">
            <div class="my-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" id="addCustomer">Add Customers
                </button>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Company Name</th>
                            <th>Address</th>
                            <th>Contact Name</th>
                            <th>Contact Email</th>
                            <th>Contact Phone</th>
                            <th>GSTIN</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $customer->company_name }}</strong></td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->contact_name }}</td>
                            <td>{{ $customer->contact_email }}</td>
                            <td>{{ $customer->contact_mobile }}</td>
                            <td>{{ $customer->gst_no }}</td>
                            <td>
                                <a class="dropdown-item editCustomer" href="javascript:void(0);" data-value="{{ $customer }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <a class="dropdown-item deleteCustomer" href="javascript:void(0);" data-value="{{ $customer->id }}">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </a>
                                <!-- <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item editCustomer" href="javascript:void(0);" data-value="{{ $customer }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item deleteCustomer" href="javascript:void(0);" data-value="{{ $customer->id }}">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </a>
                                    </div>
                                </div> -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="d-flex justify-content-center">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
        <!--/ Striped Rows -->
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
@endsection

@push('modal')
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nameModal">Add Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
            </div>
            <form id="customerForm" method="POST" action="{{ route('admin.customer.save') }}">
                <input type="hidden" id="form_action" name="form_action" value="add">
                <input type="hidden" id="customer_id" name="customer_id" value="">
                <input type="hidden" id="country_code" name="country_code" value="{{ setting('country_code') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter Company Name" />
                        </div>
                        <div class="col mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="contact_name" class="form-label">Contact Name</label>
                            <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="Enter Contact Name" />
                        </div>
                        <div class="col mb-0">
                            <label for="contact_email" class="form-label">Contact Email</label>
                            <input type="text" name="contact_email" id="contact_email" class="form-control" placeholder="xxxx@xxx.xx" />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col mb-0">
                            <label for="contact_mobile" class="form-label">Contact Mobile</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">{{ setting('currency_code') }} (+{{ setting('country_code') }})</span>
                                <input type="text" id="contact_mobile" name="contact_mobile" class="form-control" placeholder="xxxx-xxx-xxx"/>
                            </div>
                        </div>
                        <div class="col mb-0">
                            <label for="gst_no" class="form-label">GSTIN</label>
                            <input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="GSTIN"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit-btn">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nameModal">Delete Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
            </div>
            <h3>Are you sure want to delete this?</h3>
            <form id="customerDeleteForm" method="POST" action="{{ route('admin.customer.delete') }}">
                <input type="hidden" id="delete_id" name="delete_id" value="">
                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="delete-btn">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
@endpush

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $('#addCustomer').on('click', function() {

            $('#company_name').val('');
            $('#address').val('');
            $('#contact_name').val('');
            $('#contact_email').val('');
            $('#contact_mobile').val('');
            $('#gst_no').val('');

            $("#customerForm")[0].reset();
            $("#customerForm").validate().resetForm();

            $('#form_action').val('add');
            $('#customer_id').val('');
            $('#submit-btn').text('Add');
            $('#nameModal').text('Add Customer');
            $('#addModal').modal('show');
        });

        $('.editCustomer').on('click', function() {

            $("#customerForm")[0].reset();
            $("#customerForm").validate().resetForm();

            var customer = $(this).data('value');
            $('#company_name').val(customer.company_name);
            $('#address').val(customer.address);
            $('#contact_name').val(customer.contact_name);
            $('#contact_email').val(customer.contact_email);
            $('#contact_mobile').val(customer.contact_mobile);
            $('#gst_no').val(customer.gst_no);

            $('#form_action').val('edit');
            $('#customer_id').val(customer.id);
            $('#submit-btn').text('Edit');
            $('#nameModal').text('Edit Customer');
            $('#addModal').modal('show');
        });

        $("#customerForm").validate({
            rules: {
                company_name: {
                    required: true,
                    minlength: 3
                },
                address: {
                    required: true,
                    minlength: 5
                },
                contact_name: {
                    required: true,
                    minlength: 3
                },
                contact_email: {
                    required: true,
                    email: true
                },
                contact_mobile: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                }
            },
            messages: {
                company_name: {
                    required: "Please enter the company name",
                    minlength: "Company name must be at least 3 characters long"
                },
                address: {
                    required: "Please enter your address",
                    minlength: "Address must be at least 5 characters long"
                },
                contact_name: {
                    required: "Please enter the contact name",
                    minlength: "Contact name must be at least 3 characters long"
                },
                contact_email: {
                    required: "Please enter contact email address",
                    email: "Enter a valid email address"
                },
                contact_mobile: {
                    required: "Please enter the mobile number",
                    digits: "Please enter only numbers",
                    minlength: "Mobile number must be exactly 10 digits",
                    maxlength: "Mobile number must be exactly 10 digits"
                }
            },
            submitHandler: function (form) {
                $('#submit-btn').prop("disabled", true);
                $('#submit-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                form.submit();
            }
        });

        $('.deleteCustomer').on('click', function() {
            var customer_id = $(this).data('value');
            $('#delete_id').val(customer_id);
            $('#deleteModal').modal('show');
        });

        $('#customerDeleteForm').on('submit', function() {
            $('#delete-btn').prop("disabled", true);
            $('#delete-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        });
    });
</script>
@endpush
