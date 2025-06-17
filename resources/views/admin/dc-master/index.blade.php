@extends('layouts.admin')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Dc Running Sequence Master</h4>
        <!-- Striped Rows -->
        <div class="ms-auto text-end">
            <div class="my-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" id="addDcMaster">Add Dc Master
                </button>
            </div>
        </div>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Starting Number</th>
                            <th>Numbering Type (List)</th>
                            <!-- <th>Status</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($dcMasters as $dcMaster)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $dcMaster->from }}</strong></td>
                            <td><strong>{{ $dcMaster->to }}</strong></td>
                            <td>{{ $dcMaster->starting_number }}</td>
                            <td>{{ $dcMaster->numbering_type }}</td>
                            <!-- <td>{{ $dcMaster->status }}</td> -->
                            <td>
                                <a class="dropdown-item editDcMaster" href="javascript:void(0);" data-value="{{ $dcMaster }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <a class="dropdown-item deleteDcMaster" href="javascript:void(0);" data-value="{{ $dcMaster->id }}">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </a>
                                <!-- <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item editDcMaster" href="javascript:void(0);" data-value="{{ $dcMaster }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item deleteDcMaster" href="javascript:void(0);" data-value="{{ $dcMaster->id }}">
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
                    {{ $dcMasters->links() }}
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
                <h5 class="modal-title" id="nameModal">Add Dc Master</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
            </div>
            <form id="dcMasterForm" method="POST" action="{{ route('admin.dc-master.save') }}">
                <input type="hidden" id="form_action" name="form_action" value="add">
                <input type="hidden" id="dc_master_id" name="dc_master_id" value="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="from" class="form-label">From</label>
                            <input type="text" name="from" id="from" class="form-control" placeholder="Enter From" />
                        </div>
                        <div class="col mb-3">
                            <label for="to" class="form-label">To</label>
                            <input type="text" name="to" id="to" class="form-control" placeholder="Enter To" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="starting_number" class="form-label">Starting Number</label>
                            <input type="text" name="starting_number" id="starting_number" class="form-control" placeholder="Enter Starting Number" />
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
                <h5 class="modal-title" id="nameModal">Delete Dc Master</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
            </div>
            <h3>Are you sure want to delete this?</h3>
            <form id="dcMasterDeleteForm" method="POST" action="{{ route('admin.dc-master.delete') }}">
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

        $('#addDcMaster').on('click', function() {

            $('#from').val('');
            $('#to').val('');
            $('#starting_number').val('');

            $("#dcMasterForm")[0].reset();
            $("#dcMasterForm").validate().resetForm();

            $('#form_action').val('add');
            $('#dc_master_id').val('');
            $('#submit-btn').text('Add');
            $('#nameModal').text('Add Dc Master');
            $('#addModal').modal('show');
        });

        $('.editDcMaster').on('click', function() {

            $("#dcMasterForm")[0].reset();
            $("#dcMasterForm").validate().resetForm();

            var dc_master = $(this).data('value');
            $('#from').val(dc_master.from);
            $('#to').val(dc_master.to);
            $('#starting_number').val(dc_master.starting_number);

            $('#form_action').val('edit');
            $('#dc_master_id').val(dc_master.id);
            $('#submit-btn').text('Edit');
            $('#nameModal').text('Edit Dc Master');
            $('#addModal').modal('show');
        });

        $("#dcMasterForm").validate({
            rules: {
                from: {
                    required: true,
                    minlength: 1,
                    maxlength: 10
                },
                to: {
                    required: true,
                    minlength: 1,
                    maxlength: 10
                },
                starting_number: {
                    required: true,
                    digits: true,
                    minlength: 1,
                    maxlength: 10,
                }
            },
            messages: {
                from: {
                    required: "Please enter the from location",
                    minlength: "From location must be exactly 3 characters long",
                    maxlength: "From location must be exactly 3 characters long"
                },
                to: {
                    required: "Please enter your to location",
                    minlength: "To location must be exactly 3 characters long",
                    maxlength: "To location must be exactly 3 characters long"
                },
                starting_number: {
                    required: "Please enter the starting number",
                    digits: "Please enter only numbers",
                    minlength: "Mobile number must be exactly 1 digits",
                    maxlength: "Mobile number must be exactly 10 digits"
                }
            },
            submitHandler: function (form) {
                $('#submit-btn').prop("disabled", true);
                $('#submit-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                form.submit();
            }
        });

        $('.deleteDcMaster').on('click', function() {
            var dc_master_id = $(this).data('value');
            $('#delete_id').val(dc_master_id);
            $('#deleteModal').modal('show');
        });

        $('#dcMasterDeleteForm').on('submit', function() {
            $('#delete-btn').prop("disabled", true);
            $('#delete-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        });
    });
</script>
@endpush
