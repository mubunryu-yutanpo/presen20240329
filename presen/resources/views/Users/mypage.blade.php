<?php

echo 'mypage';
//dd($postedProjects);
?>

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
<div>
    <p>{{ $user->name }}さん</p>
    <img src="{{ asset($user->avatar) }}" alt="">

    <div>
        <p>POSTしたやつ</p>
        @foreach($postedProjects as $post)
            <div>
                <h2>{{ $post->title }}</h2>
                <img src="{{ asset($post->thumbnail) }}" alt="">
                <p>{{ $post->content }}</p>
                <p>￥{{ $post->price }}</p>
            </div>
        @endforeach
    </div>

</div>
</body>
</html>
