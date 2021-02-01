<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\AuthenticationException;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $captchaData = Cache::get($request->captcha_key);

        if (!$captchaData) {
            abort(403, '图形验证码已失效');
        }

        if (!hash_equals($captchaData['code'], $request->captcha_code)) {
            Cache::forget($request->captcha_key);
            throw new AuthenticationException('验证码错误');
        }
        
        $phoneNumber = $captchaData['phoneNumber'];

        // 生成4位随机数，左侧补0
        $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

        /*try {
            $result = $easySms->send($phone, [
                'template' => config('easysms.gateways.aliyun.templates.register'),
                'data' => [
                    'code' => $code
                ],
            ]);
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('aliyun')->getMessage();
            abort(500, $message ?: '短信发送异常');
        }*/

        $key = 'verificationCode_'.Str::random(15);
        $expiredAt = now()->addMinutes(5);
        // 缓存验证码 5 分钟过期。
        Cache::put($key, ['phoneNumber' => $phoneNumber, 'code' => $code], $expiredAt);

        return response()->json([
            'key' => $key,
            'code' => $code,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
