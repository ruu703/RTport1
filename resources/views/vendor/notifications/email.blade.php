@component('mail::message')

{{-- Greeting --}}

@if (! empty($greeting))

# {{ $greeting }}

@else

@if ($level === 'error')

# @lang('Whoops!')

@else

エンジニア案件マッチングサービス match をご利用いただき有難うございます。

@endif

@endif



{{-- Intro Lines --}}

@foreach ($introLines as $line)



{{ $line }}



@endforeach



{{-- Action Button --}}

@isset($actionText)

<?php

switch ($level) {

case 'success':

case 'error':

$color = $level;

break;

default:

$color = 'primary';

 }

?>

@component('mail::button', ['url' => $actionUrl, 'color' => $color])

{{ $actionText }}

@endcomponent

@endisset



{{-- Outro Lines --}}

@foreach ($outroLines as $line)

有効期限は送信後60分です。<br>
有効期限を過ぎてしまった場合はお手数ですが再度下記URLよりお手続きください。<br>
https://ruka.sakura.ne.jp/match/password/reset<br><br>

{{ $line }}



@endforeach



{{-- Salutation --}}

@if (! empty($salutation))

{{ $salutation }}

@else

{{ config('app.name') }}

@endif



{{-- Subcopy --}}

@isset($actionText)

@slot('subcopy')

{{ $actionText }}ボタンが利用できない場合は、以下のURLをコピー＆ペーストしてブラウザから直接アクセスしてください。

[{{ $actionUrl }}]({!! $actionUrl !!})

@endslot

@endisset

@endcomponent
