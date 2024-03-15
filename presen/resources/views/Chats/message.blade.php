<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>DM詳細</title>
</head>
<body>
<h1>メッセージ</h1>
<div>
    <div>
        @foreach($messages as $message)

            <div class="{{ ($message->user->id === $user_id)? 'right' : 'left' }}">
                <div>
                    <img src="{{ asset($message->user->avatar) }}" alt="">
                    <p>{{ $message->user->name }}</p>
                </div>
                <div>
                    <p>{{ $message->comment }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('dm.add', [$chat->id, $chat->user1_id, $chat->user2_id]) }}" method="post">
        @csrf
        <div>
            <input type="text" name="message" placeholder="メッセージを入力してください" required>
            <button type="submit">
                <i class=" fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </form>
</div>
</body>
</html>
