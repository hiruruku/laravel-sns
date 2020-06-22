@extends('app')
<!-- app.blade.phpの継承 -->

@section('title', '記事一覧')
<!-- titleセクションに、第2引数を埋め込む -->

@section('content')
@include('nav')
<!-- contentセクション　-->
<!-- 固定幅 -->
<div class="container">　
   @foreach($articles as $article) {{-- controllerから渡された$articles配列をloop処理 --}}
    <!-- cardクラス(card-body3つ) mt-3(spacing)-->
    <div class="card mt-3">
        <!-- d-flex >> display:flex flex-row >> flex-direction:row -->
        <div class="card-body d-flex flex-row">
            <!-- mdbootstrap(Font Awesomeでもできる -->
            <i class="fas fa-user-circle fa-3x mr-1"></i>
            <div>
                <div class="font-weight-bold">
                   {{ $article->user->name }}
                </div>
                <div class="font-weight-lighter">
                {{ $article->created_at->format('Y/m/d H:i') }} {{-- {{}}の中はXSS攻撃防御でescapeされている --}}
                </div>
            </div>
        </div>
        <div class="card-body pt-0 pb-2">
            <h3 class="h4 card-title">
                {{ $article->title }}
            </h3>
            <div class="card-text">
                {{!! nl2br(e($article->body)) !!}} {{-- e()でescape、改行コードをbrに変換し!!でエスケープ解除 --}}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection