<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\DcMaster;

class DcMasterController extends Controller
{
    public function index()
    {
        $page_title = 'Dc Masters';
        $dcMasters = DcMaster::where('status', 'active')->orderby('id', 'desc')->paginate(10);
        return view('admin/dc-master/index', compact('page_title', 'dcMasters'));
    }

    public function create(Request $request)
    {
        $dcMaster = DcMaster::whereNull('id')->first();
        return view('admin/dc-master/form', compact('dcMaster'));
    }

    public function edit($dc_master_id)
    {
        $validator = Validator::make(['dc_master_id' => $dc_master_id], [
            'dc_master_id' => 'required|exists:dc_masters,id',
        ]);

        if ($validator->fails()) {
            // return self::sentResponse(422, [], $validator->messages());
            return redirect()->route('admin.dc-master.list')->with('error', 'Invalid value!');
        }

        $dcMaster = DcMaster::findOrFail($dc_master_id);
        return view('admin/dc-master/form', compact('dcMaster'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_action' => 'required|in:add,edit',
            'dc_master_id' => 'required_if:form_action,edit|nullable|exists:dc_masters,id',
            'from' => 'required|string|min:1|max:10',
            'to' => 'required|string|min:1|max:10',
            'starting_number' => 'required|numeric|digits_between:1,10',
        ]);

        if ($validator->fails()) {
            // return self::sentResponse(422, [], $validator->messages());
            return redirect()->route('admin.dc-master.list')->with('error', $validator->messages()->first());
        }

        if($request->form_action == 'edit') {
            $dcMaster = DcMaster::findOrFail($request->dc_master_id);
            $dcMaster->updated_by = auth()->user()->id;
        } else {
            $dcMaster = new DcMaster();
            $dcMaster->created_by = auth()->user()->id;
        }

        $dcMaster->from = $request->from;
        $dcMaster->to = $request->to;
        $dcMaster->starting_number = $request->starting_number;
        $dcMaster->numbering_type = $request->from.' - '.$request->to;
        $dcMaster->save();

        if($request->form_action == 'edit') {
            return redirect()->route('admin.dc-master.list')->with('success', 'Dc Master updated successfully!');
        } else {
            return redirect()->route('admin.dc-master.list')->with('success', 'Dc Master added successfully!');
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delete_id' => 'required|exists:dc_masters,id',
        ]);

        if ($validator->fails()) {
            // return self::sentResponse(422, [], $validator->messages());
            return redirect()->route('admin.dc-master.list')->with('error', $validator->messages()->first());
        }

        $dcMaster = DcMaster::findOrFail($request->delete_id);
        $dcMaster->deleted_by = auth()->user()->id;
        $dcMaster->save();
        $dcMaster->delete();

        return redirect()->route('admin.dc-master.list')->with('success', 'Dc Master deleted successfully!');
    }
}
