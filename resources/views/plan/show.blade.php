@extends('layouts.app')

@section('block_css')
    <link rel="stylesheet" href="{{ asset('css/plans.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="breadcrumb-holder">
                <h1 class="main-title">{{ $plan->name }}</h1>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-6">
            <form method="POST" id="payment-form" action="{{ url('payment') }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <div id="waitForPaymentModule" class="justify-content-center">
                                <div class="main-title">@lang('messages.label.wait_for_payment')</div>
                            </div>
                            <div id="dropin-container"></div>
                            <span class="invalid-feedback" role="alert">
                                <strong class="error">@lang('messages.label.error_payment')</strong>
                            </span>                        
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="plan" value="{{ $plan->id }}">
                </div>
                <div class="form-group">
                    <input type="hidden" name="payment_method_nonce" id="nonce">
                </div>
                <div class="row justify-content-center">
                    <div class="form-group">
                        <button class="btn btn-primary" type="button" style="display: none;">@lang('messages.label.add')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.19.0/js/dropin.min.js"></script>
    <script src="{{ asset('js/payment.js') }}"></script>
@endsection