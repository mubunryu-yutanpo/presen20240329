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
        <input id="title" class="" type="text" name="title" required placeholder="255文字以内" value="{{ old('title') }}">
        @error('title')
            <p role="alert">{{ $message }}</p>
        @enderror

        <label for="type">プロジェクトの種類 *</label>
        <select name="type" id="type">
            <option value="" hidden="">選択してください</option>

            @foreach($types as $type)
                <option value="{{ $type->id }}" {{ old('type', $project->type ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
            @endforeach
        </select>
        @error('type')
            <p role="alert">{{ $message }}</p>
        @enderror


        <label for="price">料金 *</label>
        <input id="price" class="" type="number" name="price" required value="{{ old('price') }}">
        @error('price')
            <p role="alert">{{ $message }}</p>
        @enderror


        <label for="content">内容 *</label>
        <textarea id="content" class="" name="content" cols="30" rows="10" required placeholder="プロジェクトの内容を2,000文字以内で記入してください">{{ old('content') }}</textarea>
        @error('content')
            <p role="alert">{{ $message }}</p>
        @enderror


        <label for="thumbnail">サムネイル</label>
        <input id="thumbnail" class="" type="file" name="thumbnail" value="{{ old('thumbnail') }}">
        @error('thumbnail')
            <p role="alert">{{ $message }}</p>
        @enderror


        <input type="submit" value="登録する！">
    </form>

</div>
</body>
</html>
