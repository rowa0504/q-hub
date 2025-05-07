<?php
namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SocialLoginController extends Controller
{
    // リダイレクト処理
    public function redirectToProvider($provider){
        return Socialite::driver($provider)->redirect();
    }

    // コールバック処理
    public function handleProviderCallback($provider){
        $user = Socialite::driver($provider)->user();

        // 既存ユーザーを確認、もしくは新規登録
        $authUser = $this->findOrCreateUser($user, $provider);

        // ログイン
        Auth::login($authUser, true);

        return redirect()->to('/');  // ログイン後のリダイレクト先
    }

    // ユーザー情報の処理
    private function findOrCreateUser($socialUser, $provider){
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            return $user;
        }

        return User::create([
            'name'     => $socialUser->getName(),
            'email'    => $socialUser->getEmail(),
            'provider' => $provider,
            'password' => bcrypt(Str::random(16)),  // ソーシャルログインには必要ないのでダミーパスワードを設定
        ]);
    }
}
