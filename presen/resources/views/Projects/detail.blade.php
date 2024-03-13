<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>案件詳細</title>
</head>
<body>
<h1>案件詳細</h1>
<div>
    <h2>{{ $project->title }}</h2>
    <div>
        投稿者： {{ $user->name }}
        <img src="{{ asset($user->avatar) }}" alt="">
    </div>

    <img src="{{ asset($project->thumbnail) }}" alt="">
    <p>案件内容</p>
    <p>{{ $project->content }}</p>

    <div>
        <h3>コメント</h3>
        <div>
            @foreach($messages as $message)
                <div>
                    <div>
                        <p>{{ $message->user->name }}</p>
                        <img src="{{ asset($message->user->avatar) }}" alt="">
                    </div>
                    <div>
                        <p>{{ $message->comment }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($user->id !== Auth::id())
        {{--    ユーザーと投稿者が違う場合    --}}
        @if($applyFlg)
            <p>この案件にはすでに応募しています</p>
        @else
            <form action="{{ route('apply', $project->id) }}" method="post">
                @csrf
                <input type="submit" value="応募する！">
            </form>
        @endif
    @else
        {{--  同じ場合  --}}
        <div>
            <a href="{{ route('project.edit', $project->id) }}">編集する</a>
        </div>
    @endif
</div>
</body>
</html>
