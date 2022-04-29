@extends('layouts.index')

@section('content')

<section class="p-container">
                <div  class="p-container__wrap">
                    <h2>
                        {{ __('Reset Password') }}
                    </h2>

                    @if (session('status'))
                        <div  role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="p-container__panel">
                            <div class="p-container__inner p-container__inner--large">
                                <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                    <label for="email" class="c-label">
                                        {{ __('E-Mail Address') }}
                                    </label>
                                    <input type="email" name="email" class="c-form  c-form--input @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}"  required autocomplete="email" autofocus>
                                    
                                    @error('email')
                                    <span class="c-errormsg" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror

                                <div class="p-container__btnwrap">
                                    <button type="submit" class="c-btn p-container__submit p-container__submit--black">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="p-btnwrap p-btnwrap--m">
                        <a href="" class="c-btn c-btn--black p-btnwrap__right">
                            戻る　>
                        </a> 
                    </div>
                </div>
            </section>
@endsection
