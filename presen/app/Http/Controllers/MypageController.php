<?php

namespace App\Http\Controllers;

use App\Models\Apply;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Notification;
use App\Models\Type;
use App\Models\DirectMessage;
use App\Models\PublicMessage;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Inertia\Inertia;

class MypageController extends Controller
{
    // マイページ表示
    public function mypage(){
        try{
            // ユーザー情報の取得
            $user = User::find(Auth::id());

            // 投稿した案件の取得
            //$postedProjects = Project::where('user_id', $user->id)->latest()->take(5)->get();
            $postedProjects = Project::where('user_id', $user->id)->latest()->take(5)->get()->map(function ($project) {
                $project->detailUrl = route('project.detail', ['project_id' => $project->id]);
                return $project;
            });

            // 応募した案件
            $appliedProjects = $user->applies()->with('project')->latest()->take(5)->get()->map(function ($apply) {
                $apply->project->detailUrl = route('project.detail', ['project_id' => $apply->project->id]);
                return $apply;
            });

            // コメントした案件
            $commentedProjects = $user->public_messages()->with('project')->latest()->take(5)->get()->map(function ($comment) {
                $comment->project->detailUrl = route('project.detail', ['project_id' => $comment->project->id]);
                return $comment;
            });

            // 通知

            return Inertia::render('Profile/Mypage', [
                'user' => $user,
                'postedProjects' => $postedProjects,
                'appliedProjects' => $appliedProjects,
                'commentedProjects' => $commentedProjects,
            ]);

        }catch (Exception $e){
            // エラー時
            Log::error('getMypageエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

    // 投稿した案件一覧ページ
    public function postedProjects($user_id){
        try{

            $user = User::find($user_id);
            $projects = Project::where('user_id', $user_id)->latest()->paginate(1);

            return Inertia::render('Profile/Posts', compact('user', 'projects'));

        }catch (Exception $e){
            // エラー時
            Log::error('postedProjectsエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }
    // 応募した案件一覧ページ
    public function appliedProjects($user_id){
        try{
            $user = User::find($user_id);

            $uniqueProjectIds = Apply::where('user_id', $user_id)
                ->pluck('project_id')
                ->unique()
                ->toArray();

            $projects = Project::where('id', $uniqueProjectIds)->with('user')->paginate(5);


            return Inertia::render('Profile/Applies', compact('user', 'projects'));

        }catch (Exception $e){
            // エラー時
            Log::error('appliedProjectsエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

    // コメントした案件一覧ページ
    public function commentedProjects($user_id){
        try{

            $user = User::find($user_id);

            // ユニークなプロジェクトIDのリストを取得
            $uniqueProjectIds = PublicMessage::where('user_id', $user_id)
                ->pluck('project_id')
                ->unique()
                ->toArray();

            // プロジェクト情報を取得
            $projects = Project::whereIn('id', $uniqueProjectIds)
                ->with('user') // プロジェクトに紐づくユーザー情報も取得
                ->paginate(5);


            return Inertia::render('Profile/Comments', compact('user', 'projects'));

        }catch (Exception $e){
            // エラー時
            Log::error('commentedProjectsエラー：'. $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

}
