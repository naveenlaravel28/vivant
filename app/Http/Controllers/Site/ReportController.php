<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Packing;
use App\Models\PackingDetail;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPdfMail;
use App\Helpers\MailHelper;

class ReportController extends Controller
{
    public function index(Request $request) {

        $page_title = 'Reports';
        $customers = Customer::where('status', 'active')->get();
        $allPackings = Packing::get();

        $query = Packing::where('user_id', auth()->user()->id);

        $dcNo = $request->get('dc_no') ?? '';
        $customer = $request->get('customer') ?? '';
        $date_from = $request->get('date_from') ? Carbon::parse($request->get('date_from'))->format('Y-m-d') : '';
        $date_to = $request->get('date_to') ? Carbon::parse($request->get('date_to'))->format('Y-m-d') : '';
        $search = $request->get('search') ?? '';

        if (!empty($dcNo)) {
            $query->where('id', $dcNo);
        }

        if (!empty($customer)) {
            $query->where('customer_id', $customer);
        }

        if (!empty($date_from)) {
            $query->whereDate('billing_date', '>=', Carbon::parse($date_from)->format('Y-m-d'));
        }

        if (!empty($date_to)) {
            $query->whereDate('billing_date', '<=', Carbon::parse($date_to)->format('Y-m-d'));
        }

        if (!empty($search)) {
            $query->where('vehicle_no', $search);
            $query->orWhere('pl_no', $search);
            $query->orWhereHas('customer', function($q) use($search) {
                $q->where('company_name', 'LIKE', "%{$search}%");
            });
        }

        $packings = $query->orderBy('id', 'desc')->paginate(10);

        return view('site/report/index', compact('page_title', 'packings', 'customers', 'allPackings', 'dcNo', 'customer', 'date_from', 'date_to'));
    }

    public function pdf($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:packings,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('site.report.list')->with('error', $validator->messages()->first());
        }

        $packing = Packing::with(['pakingDetails', 'customer'])->find($id);
        $pakingDetails = PackingDetail::where('packing_id', $packing->id)->get()->groupBy('section_no');
        $customer = Customer::find($packing->customer_id);
        $admin = User::where('role', 'admin')->first();
        $logo = !blank(setting('site_logo')) ? storage_path('app/public/'.setting('site_logo')) : public_path('site/assets/images/logo.png');

        // Load the Blade view
        $pdf = Pdf::loadView('site.report.pdf', compact('packing', 'pakingDetails', 'customer', 'admin', 'logo'));
        $pdf->setOption('repeat_table_headers', false);
        // Load to Browser
        return $pdf->stream('report.pdf');
        // Download the PDF
        // return $pdf->download('report.pdf');
    }

    public function emailPdf($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:packings,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('site.report.list')->with('error', $validator->messages()->first());
        }

        $packing = Packing::with(['pakingDetails', 'customer'])->find($id);
        $pakingDetails = PackingDetail::where('packing_id', $packing->id)->get()->groupBy('section_no');
        $customer = Customer::find($packing->customer_id);
        $admin = User::where('role', 'admin')->first();
        $logo = !blank(setting('site_logo')) ? storage_path('app/public/'.setting('site_logo')) : public_path('site/assets/images/logo.png');

        $storagePath = storage_path('app/public/pdf');
            if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }
        $pdfPath = $storagePath.'/report.pdf';

        $pdf = Pdf::loadView('site.report.pdf', compact('packing', 'pakingDetails', 'customer', 'admin', 'logo'));
        $pdf->setOption('repeat_table_headers', false);
        file_put_contents($pdfPath, $pdf->output());

        MailHelper::setMailConfig();
        Mail::to(setting('report_email', 'naveen@yopmail.com'))->send(new SendPdfMail($pdfPath));

        return redirect()->route('site.report.list')->with('success', 'Pdf sent successfully!');
    }

    public function print($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:packings,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('site.report.list')->with('error', $validator->messages()->first());
        }

        $packing = Packing::with(['pakingDetails', 'customer'])->find($id);
        $pakingDetails = PackingDetail::where('packing_id', $packing->id)->get()->groupBy('section_no');
        $customer = Customer::find($packing->customer_id);
        $admin = User::where('role', 'admin')->first();
        $logo = !blank(setting('site_logo')) ? storage_path('app/public/'.setting('site_logo')) : public_path('site/assets/images/logo.png');

        return view('site.report.print', compact('packing', 'pakingDetails', 'customer', 'admin', 'logo'));
    }
}
