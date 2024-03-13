<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>案件一覧</title>
</head>
<body>
<h1>案件一覧</h1>
<div>
    @foreach($projects as $project)
        <div>
            <h2>{{ $project->title }}</h2>
            <div>
                投稿者： {{ $project->user->name }}
                <img src="{{ asset($project->user->avatar) }}" alt="">
            </div>

            <img src="{{ asset($project->thumbnail) }}" alt="">
            <p>案件内容</p>
            <p>{{ $project->content }}</p>
        </div>

    @endforeach

    {{--  paginate  --}}
    <div>
        {{ $projects->links() }}
    </div>
</div>
</body>
</html>
