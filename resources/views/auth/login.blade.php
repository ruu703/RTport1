@extends('layouts.index')

@section('content')

<section class="p-container">
                <div  class="p-container__wrap">
                    <h2>
                        {{ __('Login') }}
                    </h2>
                        <div class="p-container__panel">
                            <div class="p-container__inner p-container__inner--large">
                                <form method="POST" action="{{ route('login') }}">
                                @csrf
                                    <label for="email" class="c-label">
                                        {{ __('E-Mail Address') }}
                                    </label>
                                    <input type="text" name="email" class="c-form  c-form--input @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}"  required autocomplete="email" autofocus>
                                    
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
                                    <input type="password" name="password" class="c-form  c-form--input @error('password') is-invalid @enderror" id="password" required autocomplete="current-password">
                                    
                                    @error('password')
                                    <span class="c-errormsg" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror

                                    <div class="p-container__check">
                                        <label for="remember" class="c-label">
                                            <input type="checkbox"  class="c-form c-form--check" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                
                                <!-- <div class="p-container__wrap-registerd">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div> -->

                                <div class="p-container__btnwrap">
                                    <button type="submit" class="c-btn p-container__submit p-container__submit--black">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                <div class="p-container__wrap-registerd">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    @component('components.backlink')
                    @endcomponent
                </div>
            </section>

@endsection
