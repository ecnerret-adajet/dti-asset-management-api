<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Customer;
use Inertia\Inertia;
use App\Models\Order;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Customers/Index',[
            'filters' => $request->all('name'),
            'customers' => Customer::orderBy('created_at','desc')
                        ->withCount('orders')
                        ->filter($request->only('name'))
                        ->paginate(6)
                        ->withQueryString()
                        ->through(fn ($customer) => $customer),
        ]);
    }

    public function create()
    {
        return Inertia::render('Customers/Create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        Customer::create($request->all());

        return Redirect::route('customers')->with('success','Successfully created.');
    }

    public function show(Request $request, Customer $customer)
    {
        return Inertia::render('Customers/Show',[
            'customer' => $customer,
            'filters' => $request->all('name','order_status_id','asset_name'),
            'orders' => Order::orderBy('created_at','desc')
                        ->where('customer_id', $customer->id)
                        ->with('user','customer','orderStatus','assets')
                        ->filter($request->only(
                            'order_status_id',
                            'asset_name',
                        ))
                        ->paginate(5)
                        ->withQueryString()
                        ->through(fn ($order) => $order),
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        $customer->update($request->all());

        return Redirect::route('customers')->with('success','Successfully updated.');
    }

    public function delete(Customer $customer)
    {
        $customer->destroy();

        return Redirect::route('customers')->with('success','Successfully deleted.');
    }
}
