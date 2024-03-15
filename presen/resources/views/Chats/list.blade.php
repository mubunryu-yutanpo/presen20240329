<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DM一覧</title>
</head>
<body>
<h1>DM一覧</h1>
<div>
    @foreach($chats as $chat)
        @php
            $partner = $chat->user1_id == auth()->id() ? $chat->user2 : $chat->user1;
        @endphp

        <div>
            <div>
                {{ $partner->name }}さん
            </div>
            <a href="{{ route('chat.detail', $chat->id) }}">メッセージを確認</a>
        </div>
    @endforeach

    {{--  paginate  --}}
    <div>
        {{ $chats->links() }}
    </div>
</div>
</body>
</html>
