<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Pizza;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

//use Intervention\Image\Facades\Image;

class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pizzas = Pizza::orderBy('created_at', 'desc')->paginate(10);
        return view('pages.pizza.index', compact('pizzas'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.pizza.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);
        dd($request);
        $url = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('/uploads/images/' . $filename));
            $url = $filename;
        }
        //dd($url);
        $pizza = new Pizza;
        $pizza->name = $request->input('name');
        $pizza->description = $request->input('description');
        $pizza->price = $request->input('price');
        $pizza->url = $url;
        $pizza->save();
        return redirect('/pizza');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Pizza $pizza
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pizza = Pizza::find($id);
        return view('pages.pizza.edit', compact('pizza'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Pizza $pizza
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        $pizza = Pizza::find($id);

        $url = $pizza->url;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save(public_path('/uploads/images/' . $filename));
            $url = $filename;
        }
        $request['url'] = $url;

        $pizza->update($request->all());

        return redirect()->route('pizza.index')
            ->with('success', 'Pizza updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Pizza $pizza
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$pizza->delete();
        $exist_pizza = Pizza::join('commande_pizza', 'commande_pizza.pizza_id', '=', 'pizzas.id')
            ->find($id);
        if ($exist_pizza) {
            $exist_pizza->delete();
        } else {
            $exist_pizza->forceDelete();
        }
        return redirect()->route('pizza.index')
            ->with('success', 'Pizza deleted successfully');
    }
}
