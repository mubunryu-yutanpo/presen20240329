<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>プロジェクトの新規登録ページ</title>
</head>
<body>
<h1>プロジェクトの登録</h1>
<div>
    <form action="{{ route('project.add') }}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="title" class="">タイトル *</label>
        <input id="title" class="" type="text" name="title" required placeholder="255文字以内">
        @error('title')
            <p>{{ $message }}</p>
        @enderror

        <label for="type">プロジェクトの種類 *</label>
        <select name="type" id="type" value="選択してください">
            <option value="1">情報提供</option>
            <option value="2">案件・依頼</option>
            <option value="3">求人</option>
            <option value="4">サービス提供</option>
            <option value="5">その他</option>
        </select>
        @error('type')
            <p>{{ $message }}</p>
        @enderror


        <label for="price">料金 *</label>
        <input id="price" class="" type="number" name="price" required>
        @error('price')
            <p>{{ $message }}</p>
        @enderror


        <label for="content">内容 *</label>
        <textarea id="content" class="" name="content" id="" cols="30" rows="10" required placeholder="プロジェクトの内容を記入してください"></textarea>
        @error('content')
            <p>{{ $message }}</p>
        @enderror


        <label for="thumbnail">サムネイル</label>
        <input id="thumbnail" class="" type="file" name="thumbnail">
        @error('thumbnail')
            <p>{{ $message }}</p>
        @enderror


        <input type="submit" value="登録する！">
    </form>

</div>
</body>
</html>
