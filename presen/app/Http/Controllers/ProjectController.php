<?php

namespace App\Http\Controllers;

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

class ProjectController extends Controller
{
    // 案件一覧ページ
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

    // 案件詳細ページ
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

    // 案件への応募処理
    public function apply($project_id){
        dd('ok');
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

}
