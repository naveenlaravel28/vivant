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
                        <form class="" id="customer_form" autocomplete="off">
                            <input type="hidden" name="packing_id" id="packing_id" value="{{ $packing->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="mb-0 form-control" name="customer_id" id="customer_id">
                                            <option value="">--Choose User--</option>
                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" @if($packing->customer_id == $customer->id) selected @endif>{{ $customer->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error text-danger d-none help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control mb-0" name="vehicle_no" id="vehicle_no" placeholder="Vehicle No" value="{{ $packing->vehicle_no }}">
                                        <span class="error text-danger d-none help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{ $packing->pl_no }}" class="form-control mb-0" name="pl_no" id="pl_no" placeholder="" readonly>
                                        <span class="error text-danger d-none help-block"></span>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control mb-0" id="billing_date" value="{{ Carbon\Carbon::parse($packing->billing_date)->format('Y-m-d') }}" name="billing_date" placeholder="" readonly>
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
                        <a href="javascript:void(0);" class="btn-print" id="save_records"><i class="fas fa-floppy-o"></i>&nbsp;Update Record</a>
                        <a href="javascript:void(0);" id="reset_records" class="btn-outline">&nbsp;Reset</a>
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
        var save_packing_route = "{{ route('order.update') }}";
        var reload_route = "{{ route('site.report.list') }}";
        var packing_id = "{{ $packing->id }}";
        var scanText = '';
        var tableData = [];
        var pageLocal = localStorage.getItem('page_local');
        var pageData = localStorage.getItem('tableData');

        if((pageLocal != null && (pageLocal == 'create_order' || pageLocal != 'edit_order_'+packing_id)) || pageLocal == null) {
            localStorage.removeItem('tableData');
            localStorage.setItem('tableData', JSON.stringify(@json($packing->pakingDetails)));
        }
        localStorage.setItem('page_local', 'edit_order_'+packing_id);
    </script>
    <script src="{{ asset('site/js/html5-qrcode.min.js') }}"></script>
    <script src="{{ asset('site/js/qr-scanner.js') }}"></script>
    <script src="{{ asset('site/js/edit-script.js') }}"></script>
@endpush
