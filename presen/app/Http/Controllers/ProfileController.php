<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ValidRequest;
use App\Mail\ProfileUpdate;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $user = User::findOrFail(Auth::id());

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'profile' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ValidRequest $request): RedirectResponse
    {

//        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user = User::findOrFail(Auth::id());
        $currentavatarPath = $user->avatar;

        // サムネ画像のパス名を変数に
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            // HEIC形式の画像をJPEG形式に変換
            if ($avatar->getClientOriginalExtension() === 'heic') {
                $avatar = Image::make($avatar)->encode('jpeg');
                $filename = pathinfo($filename, PATHINFO_FILENAME) . '.jpeg';
            }

            // 画像を圧縮して保存
            $compressedImage = Image::make($avatar)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // 画像をpublic/uploadsディレクトリに移動
            $path = public_path('uploads/' . $filename);
            $compressedImage->save($path);
            $filename = '/uploads/' . $filename;

        } else {
            // サムネが未選択の場合（既にサムネがある場合はそれをそのまま保存）
            $filename = $currentavatarPath ?? 'default-avatar.png';
        }

        // DBに保存するパスが 'uploads/' で二重にならないようにチェック
        $avatar = Str::startsWith($filename, '/uploads/') ? $filename : '/uploads/' . $filename;

        $user->update([
            'name'   => $request->input('name'),
            'email'  => $request->input('email'),
            'avatar' => $avatar,
        ]);

        Mail::to($user->email)->send(new ProfileUpdate($user));

        return redirect()->route('mypage')->with([
            'message' => 'プロフィールを更新しました！',
            'status'  => 'success',
        ]);

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with([
            'message' => 'アカウントを削除しました',
            'status'  => 'success',
        ]);
    }
}
