<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Notification;
use App\Models\Type;
use App\Models\DirectMessage;
use App\Models\PublicMessage;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function getMypage(){
        // ユーザー情報の取得
        $user = User::find(Auth::id());

        // 投稿した案件の取得
        $postedProjects = Project::where('user_id', $user->id)->latest()->take(5)->get();

        // 応募した案件の取得
        $appliedProjects = $user->applies()->with('projects')->latest()->take(5)->get();

        // コメントした案件の取得
        $commentedProjects = $user->public_messages()->with('projects')->latest()->take(5)->get();

        // 通知

        // Viewに渡す
        return view('users.mypage', compact('user','postedProjects', 'appliedProjects', 'commentedProjects'));
    }
}
