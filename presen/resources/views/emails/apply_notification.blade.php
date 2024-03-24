<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
</head>
<body>
<div style="background: #f5f5ff; padding: 40px 15px;">
    <p style="text-align: center;">{{ config('app.name') }}</p>
    <div style="background: #fff; border-radius: 10px; box-shadow: 0 0 8px dimgray; margin: 40px auto; width: 70%; padding:30px;">
        <h2 style="text-align: center;">プロジェクトへの応募が完了しました</h2>

        <p style="margin:50px 0;">こんにちは {{ $user->name }} さん</p>

        <p>以下のプロジェクトへの応募が完了いたしました。依頼者からのメッセージをお待ちください。</p>

        <p>変更後のプロフィール：</p>

        <p>応募したプロジェクト名：<strong>{{ $project->title }}</strong></p>

        <p>内容：</p>

        <p>{{ $project->content }}</p>

        <div style="margin: 30px auto; width: 50%;">
            <a href="{{ route('project.detail', $project->id) }}" style="background: #cbcbff; border-radius: 10px; box-shadow: 0 0 5px #e1e1fa; padding: 15px 20px; color: black; text-decoration: none;">
                プロジェクトを確認する
            </a>
        </div>

        <p>ご利用ありがとうございます</p>
    </div>

    <p style="text-align: center; color: darkgray; font-size: 12px;">© 2024 match. All rights reserved.</p>
</div>
</body>
</html>
