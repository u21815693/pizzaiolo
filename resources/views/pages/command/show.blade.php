@extends('layouts.app')
@section('content')
    <div class="card" style="margin: 2%;">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>show Commande</h2>
                    </div>
                    <div style="text-align: end" class="pull-right">
                        <a class="btn btn-primary" href="{{ route('commande.index') }}"> Back</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>
                            User : {{ $commande->user->name }}
                        </strong>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <strong>
                            Status : {{ $commande->status }}
                        </strong>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Qte</th>
                            <th>Total</th>
                            @if(\Illuminate\Support\Facades\Auth::user()->type == 'user')
                                <th width="280px">Action</th>
                            @endif
                        </tr>
                        @foreach ($commande->pizzas as $pizza)
                            <tr>
                                <td>{{ $pizza->name }}</td>
                                <td>{{ $pizza->description }}</td>
                                <td>{{ $pizza->price }}</td>
                                <td>{{ $pizza->qte }}</td>
                                <td>{{ $pizza->total }}</td>
                                @if(\Illuminate\Support\Facades\Auth::user()->type == 'user')
                                    <td>
                                        <form action="{{ url('delete_panier',$pizza->commande_pizza_id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

