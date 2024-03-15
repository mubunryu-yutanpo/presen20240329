<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>通知一覧</title>
</head>
<body>
<h1>通知一覧</h1>
<div>
    @if($notifications->isEmpty())
    <h2>新しい通知はありません</h2>
    @else
        @foreach($notifications as $notification)
            <div>
                <div>
                    投稿者： {{ $notification->sender->name }}
                    <img src="{{ asset($notification->sender->avatar) }}" alt="">
                </div>
                <p>{{ $notification->message }}</p>

                <a href="{{ route('chat.detail', $notification->chat_id) }}">メッセージを確認する</a>

            </div>

        @endforeach

        {{--  paginate  --}}
        <div>
            {{ $notifications->links() }}
        </div>
    @endif
</div>
</body>
</html>
