<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Mypage</h1>
<a href="{{ route('chat.list', $user->id) }}" class="">メッセージ一覧へ</a>
<div>
    <p>{{ $user->name }}さん</p>
    <img src="{{ asset($user->avatar) }}" alt="">

    <a href="{{ route('project.create') }}">案件の登録</a>

    <div>
        <p>POSTしたやつ</p>
        @foreach($postedProjects as $post)
            <div>
                <a href="{{ route('project.detail', $post->id) }}">
                    <h2>{{ $post->title }}</h2>
                </a>
                <img src="{{ asset($post->thumbnail) }}" alt="">
                <p>{{ $post->content }}</p>
                <p>￥{{ $post->price }}</p>
            </div>
        @endforeach
        <a href="{{ route('posted.projects', $user->id) }}">投稿した案件一覧へ</a>
    </div>

    <div>
        <p>コメントしたやつ</p>
        @foreach($commentedProjects as $commentedPj)
            <div>
                <a href="{{ route('project.detail', $commentedPj->project->id) }}">
                    <h2>{{ $commentedPj->project->title }}</h2>
                </a>
                <img src="{{ asset($commentedPj->project->thumbnail) }}" alt="">
                <p>{{ $commentedPj->project->content }}</p>
                <p>￥{{ $commentedPj->project->price }}</p>
            </div>
        @endforeach
        <a href="{{ route('commented.projects', $user->id) }}">コメントした案件一覧へ</a>
    </div>

    <div>
        <p>応募したやつ</p>
        @foreach($appliedProjects as $appliedPj)
            <div>
                <a href="{{ route('project.detail', $appliedPj->project->id) }}">
                    <h2>{{ $appliedPj->project->title }}</h2>
                </a>
                <img src="{{ asset($appliedPj->project->thumbnail) }}" alt="">
                <p>{{ $appliedPj->project->content }}</p>
                <p>￥{{ $appliedPj->project->price }}</p>
            </div>
        @endforeach
        <a href="{{ route('applied.projects', $user->id) }}">応募した案件一覧へ</a>
    </div>



</div>
</body>
</html>
