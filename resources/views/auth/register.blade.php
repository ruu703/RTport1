<!-- 新規会員登録ページ  -->
 
@extends('layouts.index')

@section('content')

<section class="p-container">
                <div  class="p-container__wrap">
                    <h2>
                        {{ __('Register') }}
                    </h2>
                        <div class="p-container__panel">
                            <div class="p-container__inner p-container__inner--large">
                                <form method="POST" action="{{ route('register') }}">
                                @csrf
                                    <label for="email" class="c-label">
                                        {{ __('E-Mail Address') }}
                                    </label>
                                    <input type="text" name="email" class="c-form  c-form--input @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}"  required autocomplete="email">
                                    
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

                                    <label for="password-confirm" class="c-label">
                                        {{ __('Confirm Password') }}
                                    </label>
                                    <input type="password" name="password_confirmation" class="c-form  c-form--input" id="password-confirm" required autocomplete="new-password">

                                    <div class="p-container__check">
                                        <input type="checkbox"  name="check" class="c-form c-form--check @error('check') is-invalid @enderror">
                                            <span>
                                                <a href="{{ route('term') }}" class="p-container__underline" target="_blank" rel="noopener noreferrer">
                                                    利用規約
                                                </a>
                                                及び
                                                <a href="{{ route('privacy') }}" class="p-container__underline"  target="_blank" rel="noopener noreferrer">
                                                    プライバシーポリシー
                                                </a>
                                            に同意する。
                                        </span>
                                    </div>
                                    @error('check')
                                        <span class="c-errormsg" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                        @enderror
                                        
                                <div class="p-container__btnwrap">
                                    <button type="submit" class="c-btn p-container__submit p-container__submit--black">
                                        {{ __('Free Register') }}
                                        <!-- 会員登録（無料） -->
                                    </button>
                                </div>
                                <div class="p-container__wrap-registerd">
                                    <a href="{{ route('login') }}" class="p-container__underline">
                                        登録済みの方はこちら &gt;
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    @component('components.backlink')
                    @endcomponent
                </div>
            </section>

@endsection
