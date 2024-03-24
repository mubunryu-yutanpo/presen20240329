<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div style="background: #f5f5ff; padding: 40px 15px;">
    <p style="text-align: center;">{{ config('app.name') }}</p>
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 0 8px dimgray; margin: 40px auto; width: 70%; padding:30px;">
        <h2 style="text-align: center;">プロフィールの変更を受け付けました！</h2>

        <p style="margin:50px 0;">こんにちは {{ $user->name }} さん</p>

        <p>プロフィールが変更されましたのでお知らせいたします</p>

        <p>変更後のプロフィール：</p>

        <p>アカウント名：<strong>{{ $user->name }}</strong></p>

        <p>メールアドレス：<strong>{{ $user->email }}</strong></p>

        <p>ご利用ありがとうございます</p>
    </div>

    <p style="text-align: center; color: darkgray; font-size: 12px;">© 2024 match. All rights reserved.</p>
</div>
</body>
</html>
