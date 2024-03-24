<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use Inertia\Inertia;
use Mockery\Exception;
use App\Http\Requests\ValidRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function Termwind\render;


class MessageController extends Controller
{

    //===================================================================================
    // DM
    //===================================================================================

    // DM一覧(自分が関係するchat一覧)ページへ
    public function chatList($user_id){
        try {

            $chats = Chat::where('user1_id', $user_id)
                ->orWhere('user2_id', $user_id)
                ->with(['direct_messages' => function($query) {
                    // メッセージを作成日時の降順でソートして最新のものだけ取得
                    $query->latest()->take(1);
                }, 'direct_messages.user']) // メッセージとそのユーザーを事前にロード
                ->paginate(10);

            foreach ($chats as $chat) {
                // 各チャットに対して未読メッセージの有無を判定
                $chat->unread = $chat->hasUnreadMessages();

                // DMの相手情報
                $partner_id = $chat->user1_id == $user_id ? $chat->user2_id : $chat->user1_id;
                $chat->partner = User::find($partner_id);
            }

            return Inertia::render('Message/List', compact('chats'));

        } catch (Exception $e) {
            Log::error('chatListエラー：' . $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }

    // DM詳細画面
    public function chatDetail($chat_id){
        try {
            $messages = DirectMessage::where('chat_id', $chat_id)->with('user')->get();
            $user_id = Auth::id();
            $chat = Chat::findOrFail($chat_id);

            // そのチャットのメッセージは既読に変更する
            Notification::where('receiver_id', $user_id)
                        ->where('chat_id', $chat_id)
                        ->where('read', false)
                        ->update(['read' => true]);

            return Inertia::render('Message/Detail', compact('messages', 'user_id', 'chat'));

        } catch (Exception $e) {
            Log::error('chatDetailエラー：' . $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
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

            return redirect()->back()->with([
                'message' => 'メッセージを送信しました！',
                'status'  => 'success',
            ]);

        } catch (Exception $e) {
            Log::error('addDirectMessageエラー：' . $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
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
            return redirect()->back()->with([
                'message' => 'メッセージを送信しました！',
                'status'  => 'success',
            ]);

        }catch (Exception $e) {
            Log::error('addPublicMessageエラー：' . $e->getMessage());
            return redirect('/')->with([
                'message' => 'エラーが発生しました',
                'status'  => 'error',
            ]);
        }
    }
}
