@extends('layouts.index')

@section('content')

<section class="p-container">
    <div  class="p-container__wrap">
        <h2>
            {{ __('Verify Your Email Address') }}
        </h2>
        <div class="p-container__panel">
            <div class="p-container__inner p-container__inner--large">

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.

            </div>
        </div>
    </div>
</section>

@endsection
