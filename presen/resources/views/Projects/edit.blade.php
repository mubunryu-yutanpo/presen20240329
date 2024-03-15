<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>プロジェクトの編集ページ</title>
</head>
<body>
<h1>プロジェクトの編集</h1>
<div>
    <form action="{{ route('project.update', $project->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <label for="title" class="">タイトル *</label>
        <input id="title" class="" type="text" name="title" required placeholder="255文字以内" value="{{ old('title', $project->title) }}">
        @error('title')
            <p role="alert">{{ $message }}</p>
        @enderror

        <label for="type">プロジェクトの種類 *</label>
        <select name="type" id="type">
            <option value="" hidden="">選択してください</option>

            @foreach($types as $type)
                <option value="{{ $type->id }}" {{ old('type', $project->type_id ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
            @endforeach
        </select>
        @error('type')
            <p role="alert">{{ $message }}</p>
        @enderror


        <label for="price">料金 *</label>
        <input id="price" class="" type="number" name="price" required value="{{ old('price', $project->price) }}">
        @error('price')
            <p role="alert">{{ $message }}</p>
        @enderror


        <label for="content">内容 *</label>
        <textarea id="content" class="" name="content" cols="30" rows="10" required placeholder="プロジェクトの内容を2,000文字以内で記入してください">{{ old('content', $project->content) }}</textarea>
        @error('content')
            <p role="alert">{{ $message }}</p>
        @enderror


        <label for="thumbnail">サムネイル</label>
        <input id="thumbnail" class="" type="file" name="thumbnail" value="{{ old('thumbnail', $project->thumbnail) }}">
        @error('thumbnail')
            <p role="alert">{{ $message }}</p>
        @enderror


        <input type="submit" value="登録する！">
    </form>

    <form action="{{ route('project.delete', $project->id) }}" method="post">
        @csrf

        <div class="">
            <input type="submit" value="このプロジェクトを削除する" onclick="confirm('この操作は取り消せません。削除しますか？')">
        </div>
    </form>

</div>
</body>
</html>
