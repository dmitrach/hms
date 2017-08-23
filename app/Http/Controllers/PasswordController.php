<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Password_reset};
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Mail\SendToken;
use App\Services\PasswordToken;

class PasswordController extends Controller
{

    /**
     * Отобразит форму для ввода почты для отправки письма на почту
     *
     * @return \Illuminate\Http\Response
     */
    public function sendLinkResetPasswordForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Отправит ссылку для восстановления пароля.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendLinkResetPassword(Request $request)
    {
        // TODO в request
        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->firstOrFail();
        
        $token = new PasswordToken($user);
        $token->create();
        \Mail::to($user->email)->queue(new SendToken($user->password_reset->token, 'emails.reset_password', 'Восстановление пароля!')); // change to SendToken

        return view('auth.passwords.message');
    }

    /**
     * Отображает форму для ввода нового пароля, с последующим восстановлением пароля.
     *
     * @param  String  $token
     * @return \Illuminate\Http\Response
     */
    public function resetPasswordForm($token = null)
    {
      // проверка на токен (обязателен) и должен быть действительным
        return view('auth.passwords.reset', compact('token'));
    }

    /**
     * Сбрасывает пароль при действительном токене.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        // TODO если срок действия токена истек, то перенаправление (поиск записи в БД в определенному полю) и сверка времени
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|alpha_dash|max:255|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first(); // firstOrFail

        if ( $user ) {
            $password_reset = $user->password_reset()->latest()->first();

   /*$date = Carbon::parse($password_reset->created_at);
    $now = Carbon::now();
    // TOOD лучше в Model сделать возврат в нужном формате, если такого нету и вызывать оттуда метод

    $diff = $date->diffInDays(Carbon::now());*/
    //TODO время сравнить с помощью методов карбон, сверять лучше в отдельной проверке, типа Request

            if( $password_reset != null && $password_reset->token == $request->token && (Carbon::now()->timestamp - Carbon::parse($password_reset->created_at)->timestamp) < (config('auth.passwords.users.expire') * 60) ) {
                $user->password = \Hash::make($request->password);
                $user->save();
                $user->password_reset()->delete();

                return redirect()->route('auth.login');
            }
        }

        return view('auth.passwords.timeout');
    }
}
