@extends('layouts.admin')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">

    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Reports</h4>
        <form id="reportForm" method="GET" action="{{ route('admin.report.list') }}">
        <div class="flex-style">
            <div class="mb-3">
                <label for="dc_no" class="form-label">Packing List No</label>
                <select class="form-select" id="dc_no" name="dc_no">
                    <option value="" selected>Select Packing List No</option>
                    @foreach($allPackings as $row)
                        <option value="{{ $row->id }}" @if(!blank($dcNo) && $dcNo == $row->id) selected @endif>{{ $row->pl_no }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="customer" class="form-label">Customer Name</label>
                <select class="form-select" id="customer" name="customer">
                    <option value="" selected>Select Customer</option>
                    @foreach($customers as $row)
                        <option value="{{ $row->id }}" @if(!blank($customer) && $customer == $row->id) selected @endif>{{ $row->company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="html5-date-input" class="col-md-2 col-form-label">From</label>
                <input class="form-control" type="date" @if(!blank($date_from)) value="{{ $date_from }}" @endif id="date_from" name="date_from"/>
            </div>
            <div class="mb-3">
                <label for="html5-date-input" class="col-md-2 col-form-label">To</label>
                <input class="form-control" type="date" @if(!blank($date_to)) value="{{ $date_to }}" @endif id="date_to" name="date_to"/>
            </div>
            <div class="border-left mb-3">
                <label for="html5-search-input" class="col-md-2 col-form-label">Search</label>
                <input class="form-control" name="search" value="{{ old('search', Request::input('search')) }}" type="search" placeholder="Search by Keywords" id="search"/>
            </div>
        </div>
        </form>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>S No</th>
                            <th>Packing List No</th>
                            <th>Customer Name</th>
                            <th>Vehicle Number</th>
                            <th>Billing Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($packings as $packing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $packing->pl_no }}</strong></td>
                            <td>{{ $packing->customer->company_name }}</td>
                            <td>{{ $packing->vehicle_no }}</td>
                            <td>{{ $packing->billing_date }}</td>
                            <td><span @if($packing->status == 'approved') class="btn btn-success" @else class="btn btn-warning" @endif>{{ $packing->status }}</span></td>
                            <td>
                                @if($packing->status == 'approved')
                                <a class="dropdown-item viewDetails" href="javascript:void(0);" data-value="{{ $packing->pakingDetails }}" data-id="{{ $packing->id }}" data-party="{{ $packing->customer }}">
                                    <i class="bx bx-edit-alt me-1"></i> View
                                </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('admin.report.pdf', ['id' => $packing->id]) }}" target="_blank">
                                    <i class="bx bx-trash me-1"></i> PDF
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.report.send-pdf', ['id' => $packing->id]) }}">
                                    <i class="bx bx-trash me-1"></i> Send
                                </a>
                                @if($packing->status == 'pending')
                                <a class="dropdown-item" href="{{ route('admin.report.status', ['id' => $packing->id]) }}">
                                    <i class="bx bx-trash me-1"></i> Approve
                                </a>
                                @endif
                                <!-- <a class="dropdown-item deleteCustomer" href="javascript:void(0);" data-value="{{ $packing->id }}">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </a> -->
                                <!-- <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item editCustomer" href="javascript:void(0);" data-value="{{ $packing }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item deleteCustomer" href="javascript:void(0);" data-value="{{ $packing->id }}">
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
                    {{ $packings->withQueryString()->links() }}
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
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nameModal">Packing Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
            </div>
            <div class="modal-header">
                <p class="party-name"></p>
                <p class="party-address"></p>
            </div>
            <div class="modal-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Bundle No</th>
                                <th scope="col">Section No</th>
                                <th scope="col">Cut Length</th>
                                <th scope="col">Alloy&Temper</th>
                                <th scope="col">Lot No</th>
                                <th scope="col">Surface Finish</th>
                                <th scope="col">Weight</th>
                                <th scope="col">Pcs</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="pakingDetail">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="openPrintView()" class="btn btn-outline-primary" id="btn-print">Print</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@endpush

@push('scripts')
<script type="text/javascript">
    var report_list = "{{ route('admin.report.list') }}";
    $(document).ready(function() {

        $('.viewDetails').on('click', function() {
            var details = $(this).data('value');
            var party = $(this).data('party');
            var id = $(this).data('id');
            var paking = '';
            $.each(details, function(index, data) {
                paking += '<tr>'+
                            '<td>'+Number(index+1)+'</td>'+
                            '<td><strong>'+data.section_no+'</strong></td>'+
                            '<td>'+data.cut_length+'</td>'+
                            '<td>'+data.alloy+'</td>'+
                            '<td>'+data.lot_no+'</td>'+
                            '<td>'+data.surface+'</td>'+
                            '<td>'+data.weight+'</td>'+
                            '<td>'+data.pcs+'</td>'+
                            '<td>'+data.pack_date+'</td>'+
                        '</tr>';
            });
            $('#btn-print').attr('data-id', id);

            $('#pakingDetail').html(paking);
            $('.party-name').html('<strong>To: </strong>'+party.company_name);
            $('.party-address').html('<span>Address: </span>'+party.address);
            $('#viewModal').modal('show');
        });

        $('#dc_no').on('change', function() {
            $('#reportForm').submit();
        });

        $('#customer').on('change', function() {
            $('#reportForm').submit();
        });

        $('#date_from').on('change', function() {
            $('#reportForm').submit();
        });

        $('#date_to').on('change', function() {
            $('#reportForm').submit();
        });
    });

    function openPrintView() {
        // Get the current print ID from the button's data-id attribute
        let printId = document.getElementById('btn-print').getAttribute('data-id');

        if (printId) {
            // Replace ':id' in the route with the actual printId
            let printUrl = `{{ route('admin.report.print', ':id') }}`.replace(':id', printId);
            window.open(printUrl, '_blank');
        } else {
            alert('No ID found for printing.');
        }
    }
</script>
@endpush
