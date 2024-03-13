<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyCommentedProjects</title>
</head>
<body>
<h1>コメントした案件一覧ページ</h1>
<div>
    <p>{{ $user->name }}さん</p>
    <img src="{{ asset($user->avatar) }}" alt="">

    <div>
        <p>コメントしたやつ</p>
        @foreach($projects as $pj)
            <div>
                <a href="{{ route('project.detail', $pj->project->id) }}">
                    <h2>{{ $pj->project->title }}</h2>
                </a>
                <img src="{{ asset($pj->project->thumbnail) }}" alt="">
                <p>{{ $pj->project->content }}</p>
                <p>￥{{ $pj->project->price }}</p>
            </div>
        @endforeach
    </div>

    <div>
        {{ $projects->links() }}
    </div>

</div>
</body>
</html>
