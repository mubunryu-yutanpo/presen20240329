<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>案件の編集ページ</title>
</head>
<body>
<h1>案件の編集</h1>
<div>
    <h2>{{ $project->title }}</h2>

    <img src="{{ asset($project->thumbnail) }}" alt="">
    <p>案件内容</p>
    <p>{{ $project->content }}</p>

</div>
</body>
</html>
