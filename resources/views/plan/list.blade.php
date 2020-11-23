@extends('layouts.app')

@section('block_css')
    <link rel="stylesheet" href="{{ asset('css/plans.css') }}">
@endsection

@section('content')
    <div class="list">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb-holder">
                    <h1 class="main-title">Choisissez la durée de votre abonnement</h1>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($plans as $plan)
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center"><h1>{{ $plan->name }}</h1></div>
                            <div class="row justify-content-center"><label>{{ number_format($plan->cost, 2) }} €</label></div>
                            @if ($plan->description)
                                <div class="row justify-content-center"><label>{{ $plan->description }}</label></div>
                            @endif
                            <div class="row justify-content-center"><a href="{{ url('/plans', $plan->slug) }}" class="btn btn-primary">Choisir</a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection