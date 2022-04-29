<!-- フラッシュメッセージ -->

@if (session('flash_message'))
    <div class="c-flashmessage">
    {{ session('flash_message') }}
    </div>
@endif