<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ApplyNotification;
use App\Models\Type;
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
use Illuminate\Support\Str;


class MessageController extends Controller
{

    //===================================================================================
    // DM
    //===================================================================================

    // DM一覧(自分が関係するchat一覧)ページへ
    public function chatList($user_id){
        try {
            $user_id = Auth::id();

            $chats = Chat::where('user1_id', $user_id)
                ->orWhere('user2_id', $user_id)
                ->with('direct_messages.user') // メッセージとそのユーザーを事前にロード
                ->paginate(1);

            // 各チャットに対して未読メッセージの有無を判定
            foreach ($chats as $chat) {
                $chat->unread = $chat->hasUnreadMessages();
            }

            return view('Chats.list', compact('chats'));

        } catch (Exception $e) {
            Log::error('chatListエラー：' . $e->getMessage());
            return redirect('/mypage')->with('message', 'エラーが発生しました')->with('message_type', 'error');
        }
    }

    // DM詳細画面
    public function chatDetail($chat_id){
        try {
            $messages = DirectMessage::where('chat_id', $chat_id)->with('user')->get();
            $user_id = Auth::id();
            $chat = Chat::findOrFail($chat_id);

            return view('Chats.message', compact('messages', 'user_id', 'chat'));

        } catch (Exception $e) {
            Log::error('chatDetailエラー：' . $e->getMessage());
            return redirect('/mypage')->with('message', 'エラーが発生しました')->with('message_type', 'error');
        }
    }

    // DM追加
    public function addDirectMessage(ValidRequest $request, $chat_id, $user1_id, $user2_id){
        try{
            $message = $request->input('message');

            $chat = Chat::findOrFail($chat_id);

            // 新しいDirectMessageインスタンスを作成してプロパティを設定
            $directMessage = new DirectMessage;
            $directMessage->sender_id = Auth::id();
            $directMessage->comment = $message;

            // Chatモデルのリレーションを通じて保存
            $chat->direct_messages()->save($directMessage);

            // 受信者のIDを判定（現在のユーザーがuser1_idならuser2_idを、そうでなければuser1_idを受信者とする）
            $receiverId = $chat->user1_id == Auth::id() ? $chat->user2_id : $chat->user1_id;

            // 通知の新規作成
            $notification = new Notification([
                'receiver_id' => $receiverId,
                'sender_id'   => Auth::id(),
                'chat_id'    => $chat->id,
                'read'       => false,
                'message'    => '新しいメッセージがあります',
            ]);

            $notification->save();

            // とりあえずリダイレクト
            return redirect()->back()->with('message', 'メッセージを送信しました！')->with('messge_type', 'success');

        } catch (Exception $e) {
            Log::error('addDirectMessageエラー：' . $e->getMessage());
            return redirect('/mypage')->with('message', 'エラーが発生しました')->with('message_type', 'error');
        }
    }


    //===================================================================================
    // パブリックメッセージ
    //===================================================================================

    public function addPublicMessage(ValidRequest $request, $project_id){
        try{
            $message = $request->input('message');

            $publicMessage = new PublicMessage([
                'user_id'    => Auth::id(),
                'project_id' => $project_id,
                'comment'    => $message,
            ]);
            $publicMessage->save();

            // とりあえずリダイレクト
            return redirect()->back()->with('message', 'メッセージを送信しました！')->with('message_type', 'success');

        }catch (Exception $e) {
            Log::error('addPublicMessageエラー：' . $e->getMessage());
            return redirect('/mypage')->with('message', 'エラーが発生しました')->with('message_type', 'error');
        }
    }


    //===================================================================================
    // 通知一覧
    //===================================================================================
    public function notifications($user_id){
        try {
            $notifications = Notification::where('receiver_id', $user_id)->where('read', false)->with('sender')->paginate(1);

            return view('Users.notifications', compact('notifications'));

        }catch (Exception $e) {
            Log::error('addPublicMessageエラー：' . $e->getMessage());
            return redirect('/mypage')->with('message', 'エラーが発生しました')->with('message_type', 'error');
        }
    }

}
