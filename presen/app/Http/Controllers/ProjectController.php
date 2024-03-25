<?php

namespace App\Http\Controllers;

use App\Mail\ApplyNotification;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Apply;
use App\Models\Chat;
use App\Models\PublicMessage;
use App\Models\DirectMessage;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Mockery\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ValidRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    // プロジェクト一覧ページ
    public function list(Request $request){
        try{
            $option = $request->query('sort', 'newest');

            $query = $projects = Project::with('user');

            switch ($option){

                case 'newest' :
                    $query->latest();
                    break;

                case 'oldest':
                    $query->oldest();
                    break;

                case 'information' :
                    $query->where('type_id', 1);
                    break;

                case 'project' :
                    $query->where('type_id', 2);
                    break;

                case 'recruit' :
                    $query->where('type_id', 3);
                    break;

                case 'service' :
                    $query->where('type_id', 4);
                    break;

                case 'other' :
                    $query->where('type_id', 5);
                    break;

            }

            $projects = $query->paginate(6);


            return Inertia::render('Project/List', compact('projects'));

        }catch (Exception $e){
            // エラー時
            Log::error('listエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

    // プロジェクト詳細ページ
    public function detail($project_id){
        try{
            $project = Project::where('id', $project_id)->with('user')->first();
            $user = Auth::user();
            $messages = PublicMessage::where('project_id', $project->id)->with('user')->get();
            // すでに応募しているかのフラグ
            $applyFlg = Apply::where('user_id', Auth::id())
                ->where('project_id', $project_id)
                ->exists();

            return Inertia::render('Project/Detail', compact('project', 'user', 'messages', 'applyFlg'));

        }catch (Exception $e){
            // エラー時
            Log::error('detailエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

    //===================================================================================
    // プロジェクトCRUD(R以外)
    //===================================================================================


    // プロジェクトの新規作成ページへ
    public function new(){
        try{
            $types = Type::all();
            return Inertia::render('Project/New', compact('types'));

        }catch (Exception $e){
            // エラー時
            Log::error('projectのcreateエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

    // プロジェクトの新規登録処理
    public function addProject(ValidRequest $request){

        try{

            $project = new Project;

            // サムネ画像のパス名を変数に
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $filename = time() . '.' . $thumbnail->getClientOriginalExtension();

                // HEIC形式の画像をJPEG形式に変換
                if ($thumbnail->getClientOriginalExtension() === 'heic') {
                    $thumbnail = Image::make($thumbnail)->encode('jpeg');
                    $filename = pathinfo($filename, PATHINFO_FILENAME) . '.jpeg';
                }

                // 画像を圧縮して保存
                $compressedImage = Image::make($thumbnail)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // 画像をpublic/uploadsディレクトリに移動
                $path = public_path('uploads/' . $filename);
                $compressedImage->save($path);

            } else {
                // サムネが未選択の場合
                $filename = 'default-thumbnail.png';
            }

            $saved = $project->fill([
                'user_id'   => Auth::id(),
                'title'     => $request->input('title'),
                'type_id'   => $request->input('type'),
                'price'     => $request->input('price'),
                'content'   => $request->input('content'),
                'thumbnail' => '/uploads/'. $filename,
            ])->save();

            if ($saved) {
                // 成功時
                return redirect()->route('mypage')->with([
                    'message' => 'プロジェクトを投稿しました！',
                    'status'  => 'success',
                ]);
            } else {
                // 失敗時
                return redirect()->route('mypage')->with([
                    'message' => '処理に失敗しました',
                    'status'  => 'error',
                ]);
            }

        }catch (Exception $e){
            // エラー時
            Log::error('addProjectエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました。',
                'status'  => 'error',
            ]);

        }
    }

    // 編集ページへ
    public function edit($project_id){
        try{
            $project = Project::find($project_id);
            $user_id = $project->user_id;
            $types = Type::all();

            // ユーザーが違った場合
            if($user_id !== Auth::id()){
                return redirect('/')->with([
                    'message' => '不正な操作です',
                    'status'  => 'error',
                ]);
            }

            return Inertia::render('Project/Edit', compact('project', 'types'));

        }catch (Exception $e){
            // エラー時
            Log::error('edit(project)エラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

    // プロジェクトの更新
    public function updateProject(ValidRequest $request, $project_id){
        try{

            $project = Project::findOrFail($project_id);
            $currentThumbnailPath = $project->thumbnail;

            // サムネ画像のパス名を変数に
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $filename = time() . '.' . $thumbnail->getClientOriginalExtension();

                // HEIC形式の画像をJPEG形式に変換
                if ($thumbnail->getClientOriginalExtension() === 'heic') {
                    $thumbnail = Image::make($thumbnail)->encode('jpeg');
                    $filename = pathinfo($filename, PATHINFO_FILENAME) . '.jpeg';
                }

                // 画像を圧縮して保存
                $compressedImage = Image::make($thumbnail)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // 画像をpublic/uploadsディレクトリに移動
                $path = public_path('uploads/' . $filename);
                $compressedImage->save($path);
                $filename = '/uploads/' . $filename;

            } else {
                // サムネが未選択の場合（既にサムネがある場合はそれをそのまま保存）
                $filename = $currentThumbnailPath ?? 'default-thumbnail.png';
            }

            // DBに保存するパスが 'uploads/' で二重にならないようにチェック
            $thumbnail = Str::startsWith($filename, '/uploads/') ? $filename : '/uploads/' . $filename;

            $project->update([
               'title'     => $request->input('title'),
               'type_id'      => $request->input('type'),
               'price'     => $request->input('price'),
               'content'   => $request->input('content'),
               'thumbnail' => $thumbnail,
            ]);

            return redirect()->route('mypage')->with([
                'message' => 'プロジェクトを更新しました！',
                'status'  => 'success',
            ]);

        }catch (ModelNotFoundException $e){
            Log::error('updateProjectエラー：' . $e->getMessage());
            return redirect()->route('list')->with([
                'message' => '指定されたプロジェクトは存在しません',
                'status'  => 'error',
            ]);

        }catch (Exception $e){
            // エラー時
            Log::error('updateProjectエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

    // プロジェクトの削除
    public function deleteProject($project_id){

        try {

            if (!ctype_digit($project_id)) {
                return redirect('/')->with('message', '不正な操作が行われました')->with('message_type', 'error');
            }

            $project = Project::findOrFail($project_id);

            $project->delete();

            return redirect()->route('mypage')->with([
                'message' => 'プロジェクトを削除しました',
                'status'  => 'success',
            ]);


        }catch (ModelNotFoundException $e){
            Log::error('deleteProjectエラー：' . $e->getMessage());
            return redirect()->route('mypage')->with([
                'message' => '指定されたプロジェクトは存在しません',
                'status'  => 'error',
            ]);
        }catch (Exception $e){
            // エラー時
            Log::error('deleteProjectエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

    // プロジェクトへの応募処理
    public function apply($project_id){
        try{

            $user = User::findOrFail(Auth::id());
            $project = Project::findOrFail($project_id);

            Apply::create([
                'user_id' => $user->id,
                'project_id' => $project_id,
            ]);

            // チャットが既に存在するか確認
            $chat = Chat::where(function($query) use ($user, $project) {
                $query->where('user1_id', $user->id)
                    ->where('user2_id', $project->user_id);
            })->orWhere(function($query) use ($user, $project) {
                $query->where('user1_id', $project->user_id)
                    ->where('user2_id', $user->id);
            })->first();

            // 既存のチャットがなければ新しく作成
            if (!$chat) {
                $chat = Chat::create([
                    'user1_id' => $user->id,
                    'user2_id' => $project->user_id,
                ]);
            }

            // プロジェクトの投稿者から応募者へのメッセージをチャットに追加
            DirectMessage::create([
                'chat_id' => $chat->id,
                'sender_id' => $project->user_id,
                'receiver_id' => $user->id,
                'comment' => 'プロジェクトへのご応募ありがとうございます！',
            ]);

            // ユーザーにメールで通知
            Mail::to($user->email)->send(new ApplyNotification($user, $project));


            return redirect()->route('chat.detail', ['chat_id' => $chat->id])->with([
                'message' => '応募が完了しました！メッセージを送りましょう！',
                'status'  => 'success',
            ]);

        }catch (Exception $e){
            // エラー時
            Log::error('applyエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

}
