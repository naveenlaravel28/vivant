<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Packing;
use App\Models\User;
use App\Models\PackingDetail;
use App\Models\DcMaster;
use Validator;
use Carbon\Carbon;
use Setting;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'user']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $customers = Customer::where('status', 'active')->get();
        $dcMasters = DcMaster::where('status', 'active')->get();
        // $financialYear = self::PlNoGenerate(auth()->user()->location);
        
        return view('site/home/home', compact('customers', 'dcMasters'));
    }

    public function savePackings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'dc_master_id' => 'required|exists:dc_masters,id',
            'vehicle_no' => 'required|string|max:20',
            'pl_no' => 'required|string|max:50',
            'billing_date' => 'required|date_format:Y-m-d',
            'packing_data' => 'required',
        ]);

        if ($validator->fails()) {
            return self::sentResponse(422, [], $validator->messages());
        }

        $packing = Packing::where('pl_no', $request->pl_no)->first();
        if($packing) {
            $packing->updated_by = auth()->user()->id;
        } else {
            $packing = new Packing();
            $packing->created_by = auth()->user()->id;
            $packing->user_id = auth()->user()->id;
            $packing->pl_no = $request->pl_no;
        }
        $packing->customer_id = $request->customer_id;
        $packing->dc_master_id = $request->dc_master_id;
        $packing->vehicle_no = $request->vehicle_no;
        $packing->billing_date = Carbon::parse($request->billing_date)->format('Y-m-d');
        $packing->save();

        $packingData = json_decode($request->packing_data);
        foreach ($packingData as $row) {
            $packingDetail = new PackingDetail();
            $packingDetail->packing_id = $packing->id;
            $packingDetail->section_no = $row->section_no;
            $packingDetail->cut_length = $row->cut_length;
            $packingDetail->alloy = $row->alloy;
            $packingDetail->lot_no = $row->lot_no;
            $packingDetail->surface = $row->surface;
            $packingDetail->weight = $row->weight;
            $packingDetail->pcs = $row->pcs;
            $packingDetail->pack_date = $row->pack_date;
            $packingDetail->save();
        }

        return self::sentResponse(200, [], 'Records saved successfully!');
    }

    public function editOrder($id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:packings,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('site.report.list')->with('error', $validator->messages()->first());
        }

        $packing = Packing::with('pakingDetails')->find($id);
        $customers = Customer::where('status', 'active')->get();
        
        return view('site/home/edit', compact('packing', 'customers'));
    }

    public function updatePackings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'packing_id' => 'required|exists:packings,id',
            'customer_id' => 'required|exists:customers,id',
            'vehicle_no' => 'required|string|max:20',
            // 'pl_no' => 'required|string|max:50',
            // 'billing_date' => 'required|date_format:Y-m-d',
            'packing_data' => 'required',
        ]);

        if ($validator->fails()) {
            return self::sentResponse(422, [], $validator->messages());
        }

        $packing = Packing::find($request->packing_id);
        $packing->updated_by = auth()->user()->id;
        $packing->customer_id = $request->customer_id;
        $packing->vehicle_no = $request->vehicle_no;
        // $packing->billing_date = Carbon::parse($request->billing_date)->format('Y-m-d');
        $packing->save();

        $packingData = json_decode($request->packing_data);
        PackingDetail::where('packing_id', $packing->id)->delete();
        foreach ($packingData as $row) {
            // $packingDetail = PackingDetail::find($row->id);
            // if(!$packingDetail) {
                
            // }
            $packingDetail = new PackingDetail();
            $packingDetail->packing_id = $packing->id;
            $packingDetail->section_no = $row->section_no;
            $packingDetail->cut_length = $row->cut_length;
            $packingDetail->alloy = $row->alloy;
            $packingDetail->lot_no = $row->lot_no;
            $packingDetail->surface = $row->surface;
            $packingDetail->weight = $row->weight;
            $packingDetail->pcs = $row->pcs;
            $packingDetail->pack_date = $row->pack_date;
            $packingDetail->save();
        }

        return self::sentResponse(200, [], 'Records updated successfully!');
    }

    public function plGenerate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dc_master_id' => 'required|exists:dc_masters,id',
        ]);

        if ($validator->fails()) {
            return self::sentResponse(422, [], $validator->messages());
        }

        $dcMaster = DcMaster::find($request->dc_master_id);
        if($dcMaster) {
            $financialYear = self::PlNoGenerate($dcMaster);
            return self::sentResponse(200, $financialYear, 'Record fetched successfully!');
        } else {
            return self::sentResponse(500, [], 'No records found!');
        }
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
        $logo = public_path('site/assets/images/logo.png'); 

        // Load the Blade view
        $pdf = Pdf::loadView('admin.report.pdf', compact('packing', 'pakingDetails', 'customer', 'admin', 'logo'));
        $pdf->setOption('repeat_table_headers', false);
        // Load to Browser
        return $pdf->stream('report.pdf');
        // Download the PDF
        // return $pdf->download('report.pdf');
    }
}
