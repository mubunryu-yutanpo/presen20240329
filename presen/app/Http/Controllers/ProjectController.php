<?php

namespace App\Http\Controllers;

use App\Mail\ApplyNotification;
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
use Mockery\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\ValidRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;


class ProjectController extends Controller
{
    // プロジェクト一覧ページ
    public function list(){
        try{
            $projects = Project::with('user')->paginate(6);

            return view('Projects.list', compact('projects'));

        }catch (Exception $e){
            // エラー時
            Log::error('listエラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
        }
    }

    // プロジェクト詳細ページ
    public function detail($project_id){
        try{
            $project = Project::where('id', $project_id)->first();
            $user = $project->user;
            $messages = PublicMessage::where('project_id', $project->id)->with('user')->latest()->get();
            // すでに応募しているかのフラグ
            $applyFlg = Apply::where('user_id', Auth::id())
                ->where('project_id', $project_id)
                ->exists();

            return view('projects.detail', compact('project', 'user', 'messages', 'applyFlg'));

        }catch (Exception $e){
            // エラー時
            Log::error('detailエラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
        }
    }

    //===================================================================================
    // プロジェクトCRUD
    //===================================================================================


    // プロジェクトの新規作成ページへ
    public function create(){
        return view('Projects.create');
    }

    // プロジェクトの新規登録処理
    public function addProject(ValidRequest $request){
        try{

            $project = new Project;

            // サムネ画像のパス名を変数に
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $filename = $thumbnail->getClientOriginalName();

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
                'title'     => $request->title,
                'type_id'   => $request->type,
                'price'     => $request->price,
                'content'   => $request->content,
                'thumbnail' => 'uploads/'. $filename,
            ])->save();

            if ($saved) {
                // 成功時
                return redirect('/mypage')->with('message', 'プロジェクトを投稿しました！')->with('message_type', 'success');
            } else {
                // 失敗時
                return redirect()->back()->with('message', 'データの更新に失敗しました')->with('message_type', 'error');
            }

        }catch (Exception $e){
            // エラー時
            Log::error('addProjectエラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
        }
    }

    // 編集ページへ
    public function edit($project_id){
        try{
            $project = Project::find($project_id);
            $user_id = $project->user_id;

            // ユーザーが違った場合
            if($user_id !== Auth::id()){
                return redirect('/')->with('message', '不正な操作です')->with('message_type', 'error');
            }

            return view('Projects.edit', compact('project'));

        }catch (Exception $e){
            // エラー時
            Log::error('edit(project)エラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
        }
    }

    // プロジェクトの更新
    public function updateProject($project_id){}


    // プロジェクトの削除
    public function deleteProject($project_id){
        try {

            if (!ctype_digit($project_id)) {
                return redirect('/')->with('message', '不正な操作が行われました')->with('message_type', 'error');
            }

            $project = Project::findOrFail($project_id);

            $project->delete();

            return redirect('/mypage')->with('message', 'プロジェクトを削除しました')->with('message_type', 'success');


        }catch (ModelNotFoundException $e){
            Log::error('deleteProjectエラー：' . $e->getMessage());
            return redirect('list')->with('message', '指定されたプロジェクトは存在しません')->with('message_type', 'error');

        }catch (Exception $e){
            // エラー時
            Log::error('deleteProjectエラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
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

            // ユーザーにメールで通知
            Mail::to($user->email)->send(new ApplyNotification($user, $project));


            return redirect()->back()->with('message', '応募しました！')->with('message_type', 'success');

        }catch (Exception $e){
            // エラー時
            Log::error('applyエラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
        }
    }

}
