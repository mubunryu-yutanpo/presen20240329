<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyPosts</title>
</head>
<body>
<h1>投稿した案件一覧ページ</h1>
<div>
    <p>{{ $user->name }}さん</p>
    <img src="{{ asset($user->avatar) }}" alt="">

    <div>
        <p>POSTしたやつ</p>
        @foreach($projects as $post)
        <div>
            <a href="{{ route('project.detail', $pj->project->id) }}">
                <h2>{{ $post->title }}</h2>
            </a>
            <img src="{{ asset($post->thumbnail) }}" alt="">
            <p>{{ $post->content }}</p>
            <p>￥{{ $post->price }}</p>
        </div>
        @endforeach
    </div>

    <div>
        {{ $projects->links() }}
    </div>

</div>
</body>
</html>
