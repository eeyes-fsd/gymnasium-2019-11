<?php

namespace App\Observers;

use App\Models\User;
use Endroid\QrCode\ErrorCorrectionLevel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;

class UserObserver
{
    /**
     * @param User $user
     */
    public function saving(User $user)
    {
        if (!$user->share_id)
        {
            $user->share_id = Str::uuid();
            $share_url = route('register') . '?' . http_build_query(['share_id' => $user->share_id->toString()]);
            $qr_code = new QrCode($share_url);

            $qr_code->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());

            $file_name = 'public/qr-code/' . $user->share_id . '.png';

            if (file_exists($file_name)) {
                unlink($file_name);
            }

            $result = Storage::put($file_name, $qr_code->writeString());
        }
    }
}
