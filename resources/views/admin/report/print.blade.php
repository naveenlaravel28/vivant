<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box {
            width: 100%;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: center; }
        .text-right { text-align: right; }
        thead { display: table-row-group; }
        .bold-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
    </style>
    <script>
        window.onload = function() {
            window.print(); // Auto trigger print
            setTimeout(function () {
                window.close(); // Auto close after print
            }, 500);
        };
    </script>
</head>
<body>
    <div class="invoice-box">
        @php
            $totalCount = 0;
            $totalPcs = 0;
            $totalWeight = 0;
        @endphp

        <table>
            <thead>
                <tr>
                    <td colspan="9" rowspan="1">
                        <table style="border: none; margin-top: 0px;">
                            <tr style="border: none;">
                                <td style="text-align: left; vertical-align: top; border: none;">
                                    <strong>{{ setting('site_name', config('app.name')) }} SOLUTIONS PVT.LTD.</strong>
                                    <p style="font-size: 14px;"><strong>Billing To:</strong> {{ $packing->customer->company_name }}</p>
                                    <p style="font-size: 14px;">{{ $packing->customer->address }}</p>
                                </td>
                                <td style="text-align: right; vertical-align: top; border: none;">
                                    <img src="{{ !blank(setting('site_logo')) ? \Storage::url(setting('site_logo')) : asset('site/assets/images/logo.png') }}" style="width: 150px; height: auto; max-height: 80px;">
                                    <p style="font-size: 14px;">{!! $admin->address !!}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th colspan="9" style="text-align: center; font-weight: bold;">PACKING LIST</th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: center; font-weight: bold;">PL No: {{ $packing->pl_no }}</th>
                    <th colspan="4" style="text-align: center; font-weight: bold;">Date: {{ \Carbon\Carbon::parse($packing->billing_date)->format('d-m-Y') }}</th>
                </tr>
            </thead>
            @foreach($pakingDetails as $details)
            @php
                $count = 0;
                $pcs = 0;
                $weight = 0;
            @endphp
            <thead>
                <tr>
                    <th>Bundle No</th>
                    <th>Section No</th>
                    <th>Cut Length</th>
                    <th>Alloy & Temper</th>
                    <th>Lot No</th>
                    <th>Surface Finish</th>
                    <th>Weight</th>
                    <th>Pcs</th>
                    <th>Packaging Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($details as $item)
                @php
                    $count++;
                    $pcs = $pcs + $item->pcs;
                    $weight = $weight + $item->weight;
                @endphp
                <tr>
                    <td>{{ $count }}</td>
                    <td>{{ $item->section_no }}</td>
                    <td>{{ $item->cut_length }}</td>
                    <td>{{ $item->alloy }}</td>
                    <td>{{ $item->lot_no }}</td>
                    <td>{{ $item->surface }}</td>
                    <td>{{ $item->weight }}</td>
                    <td>{{ $item->pcs }}</td>
                    <td>{{ $item->pack_date }}</td>
                </tr>
                @endforeach
                @php
                    $totalCount = $totalCount + $count;
                    $totalPcs = $totalPcs + $pcs;
                    $totalWeight = $totalWeight + $weight;
                @endphp
                <tr class="bold-row">
                    <td></td>
                    <td colspan="5">Sub Total</td>
                    <td>{{ $weight }}</td>
                    <td>{{ $pcs }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
            @endforeach
            <tbody>
                <tr>
                    <td colspan="9" style="text-align: center; font-weight: bold;">Total</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center; font-weight: bold;">No of Bundles</td>
                    <td colspan="3" style="text-align: center; font-weight: bold;">No of Pcs</td>
                    <td colspan="3" style="text-align: center; font-weight: bold;">Kgs</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center; font-weight: bold;">{{ $totalCount }}</td>
                    <td colspan="3" style="text-align: center; font-weight: bold;">{{ $totalPcs }}</td>
                    <td colspan="3" style="text-align: center; font-weight: bold;">{{ $totalWeight }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>