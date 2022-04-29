{{Form::open(['method' => 'get', 'route' => 'search'])}}
    {{Form::label('word', 'フリーワード検索', ['class' => 'c-label'])}}
    <div class="p-container__search">
        {{Form::text('word', old('word', $word ?? ''), ['class' => 'c-form c-form--input', 'id' => 'word', 'placeholder' => 'フリーワードで案件を検索'])}}
    </div>
    {{Form::label('category', '案件種別で検索', ['class' => 'c-label'])}}
    {{Form::select('category', 
        ['' => '選択してください', 
         '1' => '単発案件',
         '2' => 'レベニューシェア案件'],
          old('category', $category), ['class' => 'c-form c-form--input', 'id' => 'category'] )}}
        <div class="p-container__btnwrap">
            {{Form::submit('検索', ['class' => 'c-btn p-container__submit p-container__submit--black'])}}
        </div>
{{Form::close()}}