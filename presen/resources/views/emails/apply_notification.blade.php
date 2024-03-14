<x-mail::message>
    #　プロジェクトへの応募が完了しました

    こんにちは {{ $user->name }}　さん！

    応募したプロジェクト名：**{{ $project->title }}**

    内容：

    {{ $project->content }}

    @component('mail::button', ['url' => route('project.detail', ['project_id' => $project->id])])
        このプロジェクトを確認する
    @endcomponent

    ご利用ありがとうございます
    {{ config('app.name') }}
</x-mail::message>
