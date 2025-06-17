@extends('layouts.app')
@push('css')
<style type="text/css">
    #reader {
      width: 100%;
      max-width: 350px;
      aspect-ratio: 1 / 1;
      margin: 20px auto;
      border: 2px solid #ddd;
      border-radius: 8px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush
@section('content')
<section class="banner-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card w-100 border-0 background-none height-section">
                    <div class="card-body pt-0 text-white d-flex flex-style">
                        <h3 class="mb-3 text-white">Packing List</h3>
                        <form class="" action="#" id="customer_form" autocomplete="off">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="mb-0 form-control" name="dc_master_id" id="dc_master_id">
                                            <option value="">--Numbering Type--</option>
                                            @foreach($dcMasters as $dcMaster)
                                            <option value="{{ $dcMaster->id }}">{{ $dcMaster->numbering_type }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger d-none help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="mb-0 form-control" name="customer_id" id="customer_id">
                                            <option value="">--Company--</option>
                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger d-none help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control mb-0" name="vehicle_no" id="vehicle_no" placeholder="Vehicle No">
                                        <span class="error text-danger d-none help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control mb-0" id="billing_date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="billing_date" placeholder="" readonly>
                                        <span class="error text-danger d-none help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control mb-0" name="pl_no" id="pl_no" placeholder="Packing List Number" readonly>
                                        <span class="error text-danger d-none help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group mt-4">
                            <a href="javascript:;" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#qrScannerModal">Scan Barcode</a>
                            <!-- <a href="javascript:;" class="btn btn-lg btn-secondary">Retake</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="body-section">
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-8">
                <div class="card border-0 billing-invoice-wrapper bg-white custom-shadow">
                    <div class="bill-header">
                        <h3>Record Lists</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless">
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
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="scan-data">
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="print-style">
                        <a href="javascript:void(0);" class="btn-print" id="save_records"><i class="fas fa-floppy-o"></i>&nbsp;Save Record</a>
                        <a href="javascript:void(0);" class="btn-outline" id="reset_records">&nbsp;Reset</a>
                    </div>
                </div>
            </div>
        </div>
   </div>
</section>
@endsection

@push('modal')
<!-- Modal -->
<div class="modal fade" id="qrScannerModal" data-backdrop="static" tabindex="-1" aria-labelledby="qrScannerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrScannerModalLabel">QR Code Scanner</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="reader"></div>
                <select id="camera-select" class="form-control mb-3"></select>
                <div id="result">Scan result will appear here</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="scan-btn" disabled>Confirm</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@endpush

@push('scripts')
    <audio id="beep-sound" src="{{ asset('site/audio/beep.mp3') }}" preload="auto"></audio>
    <script type="text/javascript">
        var save_packing_route = "{{ route('save-packing') }}";
        var reload_route = "{{ route('site.report.list') }}";
        var pl_route = "{{ route('pl-generate') }}";
        var scanText = '';
        var tableData = [];
        var pageLocal = localStorage.getItem('page_local');
        if((pageLocal != null && pageLocal != 'create_order') || pageLocal == null) {
            localStorage.removeItem('tableData');
        }
        localStorage.setItem('page_local', 'create_order');

        $(document).ready(function() {
            $(document).on('change', '#dc_master_id', function() {

                var formData = new FormData();
                formData.append('dc_master_id', $('#dc_master_id').val());
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                // ajax adding data to database
                $.ajax({
                    url: pl_route,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if(data.code == '200') {
                            $('#pl_no').val(data.data);
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function (jqXHR) {
                        var errors = jqXHR.responseJSON;
                        if (jqXHR.status === 401)
                            //redirect if not authenticated category.
                            window.location.reload();
                        if (jqXHR.status === 422) {
                            $.each(errors.message, function (key, value) {
                                var fieldKey = key.replace(/\./g, "_");
                                $("#" + fieldKey)
                                .next(".help-block")
                                .html(value[0])
                                .removeClass("d-none"); // showing only the first error.
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: errors.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                });
            });
        });

    </script>
    <script src="{{ asset('site/js/html5-qrcode.min.js') }}"></script>
    <script src="{{ asset('site/js/qr-scanner.js') }}"></script>
    <script src="{{ asset('site/js/script.js') }}"></script>
@endpush
