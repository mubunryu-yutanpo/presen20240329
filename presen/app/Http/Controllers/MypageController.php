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

class MypageController extends Controller
{
    // マイページ表示
    public function getMypage(){
        try{
            // ユーザー情報の取得
            $user = User::find(Auth::id());

            // 投稿した案件の取得
            $postedProjects = Project::where('user_id', $user->id)->latest()->take(5)->get();

            // 応募した案件の取得
            $appliedProjects = $user->applies()->with('project')->latest()->take(5)->get();

            // コメントした案件の取得
            $commentedProjects = $user->public_messages()->with('project')->latest()->take(5)->get();

            // 通知

            // Viewに渡す
            return view('users.mypage', compact('user','postedProjects', 'appliedProjects', 'commentedProjects'));

        }catch (Exception $e){
            // エラー時
            Log::error('getMypageエラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
        }
    }

    // 投稿した案件一覧ページ
    public function postedProjects($user_id){
        try{

            $user = User::find($user_id);
            $projects = Project::where('user_id', $user_id)->latest()->paginate(1);

            return view('users.posts', compact('user','projects'));

        }catch (Exception $e){
            // エラー時
            Log::error('postedProjectsエラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
        }
    }
    // 応募した案件一覧ページ
    public function appliedProjects($user_id){
        try{
            $user = User::find($user_id);
            $projects = Apply::where('user_id', $user->id)->with('project')->paginate(5);

            return view('Users.applies', compact('user', 'projects'));

        }catch (Exception $e){
            // エラー時
            Log::error('appliedProjectsエラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
        }
    }

    // コメントした案件一覧ページ
    public function commentedProjects($user_id){
        try{
            $user = User::find($user_id);
            $projects = PublicMessage::where('user_id', $user->id)->with('project')->paginate(5);

            return view('Users.comments', compact('user', 'projects'));

        }catch (Exception $e){
            // エラー時
            Log::error('commentedProjectsエラー：'. $e->getMessage());
            return redirect('/')->with('message', 'エラーが発生しました。')->with('message_type', 'error');
        }
    }

}
