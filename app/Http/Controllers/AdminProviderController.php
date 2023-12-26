<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class AdminProviderController extends Controller
{
    public function index($providers = null)
    {   
        if (is_null($providers)) {
            $providers = Provider::oldest();
        }

        $props = [
            'providers' => $providers->paginate(10)
        ];

        return view('admin.providers', ['props' => $props]);
    }

    public function filter()
    {   
        $providers = Provider::oldest();

        if(request('sort_by_time') == 'latest') {
            $providers = Provider::latest();
        }

        if(request('search')) {
            $providers->where('name', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%');
        }

        return $this->index($providers);
    }

    public function store()
    {   
        $attributes = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'email|max:255',
            'address' => 'string|max:255',
        ]);

        if (!(Provider::where('name', $attributes['name'])->get()->count() > 0) &&
            !(Provider::where('phone', $attributes['phone'])->get()->count() > 0) &&
            !(Provider::where('email', $attributes['email'])->get()->count() > 0)) {
            Provider::create($attributes);
            return redirect('/admin/providers')->with('success', 'New provider added');
        } else {
            return redirect('/admin/providers')->with('failed', 'Provider name, email, or phone is already existed');
        }
    }

    public function update(Provider $provider)
    {
        $attributes = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'email|max:255',
            'address' => 'string|max:255',
        ]);

        if (!(Provider::where('name', $attributes['name'])->get()->count() == 1) &&
            !(Provider::where('phone', $attributes['phone'])->get()->count() == 1) &&
            !(Provider::where('email', $attributes['email'])->get()->count() == 1)) {
            $provider->update($attributes);
            return redirect('/admin/providers')->with('success', 'Your changes have been saved');
        } else {
            return redirect('/admin/providers')->with('failed', 'Provider name, email or phone is already existed');
        }
    }

    public function destroy(Provider $provider)
    {   
        $products = $provider->products;
        //for each products in this provider, assign it to default provider
        foreach ($products as $product) {
            $product->update([
                'provider_id' => 1
            ]);
        }
        //delete this provider if it's not default provider
        if ($provider->id != 1) {
            $provider->delete();
            return redirect('/admin/providers')->with('success', 'Provider deleted');
        } else {
            return redirect('/admin/providers')->with('failed', 'Can\'t delete default provider');
        }
    }

    public function destroyAll(Request $request)
    {
        $selectedProvider = $request->input('selected', []);
        
        $providers = Provider::whereIn('id', $selectedProvider)->get();

        $flag = 0;
        foreach ($providers as $provider) {
            if ($provider->id == 1) {
                $flag = 1; continue;
            }
            $provider->delete();
        }
        $message = ['success', 'Selected providers have been deleted'];
        if ($flag == 1) $message = ['failed', 'Can\'t delete protected record'];
        return redirect('/admin/providers')->with($message[0],$message[1]);
    }
}
