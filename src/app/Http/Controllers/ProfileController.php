<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * プロフィール設定画面（初回ログイン時表示）
     */
    public function setup()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    /**
     * プロフィール情報の更新処理
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // プロフィール画像の保存（選択された場合のみ）
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $user->image_path = $path;
        }

        //  各項目を更新
        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');
        $user->is_profile_completed = true;

        $user->save();

        // 更新後マイページへリダイレクト
        return redirect()->route('mypage.index')->with('success', 'プロフィールを更新しました！');
    }
}
