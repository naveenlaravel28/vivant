<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $page_title = 'Customers';
        $customers = Customer::where('status', 'active')->orderby('id', 'desc')->paginate(10);
        return view('admin/customer/index', compact('page_title', 'customers'));
    }

    public function create(Request $request)
    {
        $customer = Customer::whereNull('id')->first();
        return view('admin/customer/form', compact('customer'));
    }

    public function edit($customer_id)
    {
        $validator = Validator::make(['customer_id' => $customer_id], [
            'customer_id' => 'required|exists:customers,id',
        ]);

        if ($validator->fails()) {
            // return self::sentResponse(422, [], $validator->messages());
            return redirect()->route('admin.customer.list')->with('error', 'Invalid value!');
        }

        $customer = Customer::findOrFail($customer_id);
        return view('admin/customer/form', compact('customer'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_action' => 'required|in:add,edit',
            'customer_id' => 'required_if:form_action,edit|nullable|exists:customers,id',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'mobile' => 'required|numeric|digits_between:7,15',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            // return self::sentResponse(422, [], $validator->messages());
            return redirect()->route('admin.customer.list')->with('error', $validator->messages()->first());
        }

        if($request->form_action == 'edit') {
            $customer = Customer::findOrFail($request->customer_id);
            $customer->updated_by = auth()->user()->id;
        } else {
            $customer = new Customer();
            $customer->created_by = auth()->user()->id;
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        $customer->address = $request->address;
        $customer->save();

        if($request->form_action == 'edit') {
            return redirect()->route('admin.customer.list')->with('success', 'Customer updated successfully!');
        } else {
            return redirect()->route('admin.customer.list')->with('success', 'Customer added successfully!');
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delete_id' => 'required|exists:customers,id',
        ]);

        if ($validator->fails()) {
            // return self::sentResponse(422, [], $validator->messages());
            return redirect()->route('admin.customer.list')->with('error', $validator->messages()->first());
        }

        $customer = Customer::findOrFail($request->delete_id);
        $customer->deleted_by = auth()->user()->id;
        $customer->save();
        $customer->delete();

        return redirect()->route('admin.customer.list')->with('success', 'Customer deleted successfully!');
    }
}
