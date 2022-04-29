@extends('layouts.index')

@section('content')

<section class="p-container">
                <div  class="p-container__wrap">
                    <h2>
                        {{ __('Reset Password') }}
                    </h2>
                        <div class="p-container__panel">
                            <div class="p-container__inner p-container__inner--large">
                                <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                    <label for="email" class="c-label">
                                        {{ __('E-Mail Address') }}
                                    </label>
                                    <input type="text" name="email" class="c-form  c-form--input @error('email') is-invalid @enderror" id="email" value="{{ $email ?? old('email') }}"  required autocomplete="email" autofocus>
                                    
                                    @error('email')
                                    <span class="c-errormsg" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror

                                    <label for="password" class="c-label">
                                        {{ __('Password') }}
                                    </label>
                                    <input type="password" name="password" class="c-form  c-form--input @error('password') is-invalid @enderror" id="password" required autocomplete="new-password">
                                    
                                    @error('password')
                                    <span class="c-errormsg" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror

                                    <label for="password_confirmation" class="c-label">
                                        {{ __('Confirm Password') }}
                                    </label>
                                    <input type="password" name="password_confirmation" class="c-form  c-form--input" id="password_confirmation" required autocomplete="new-password">


                                <div class="p-container__btnwrap">
                                    <button type="submit" class="c-btn p-container__submit p-container__submit--black">
                                        {{ __('Reset Password') }}
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
