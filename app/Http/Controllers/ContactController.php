<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:3', 'max:2000'],
        ], [
            'email.required'   => 'Vui lòng nhập email.',
            'email.email'      => 'Email không hợp lệ.',
            'message.required' => 'Vui lòng nhập nội dung.',
        ]);

        $userEmail   = $data['email'];
        $userSubject = trim(preg_replace("/[\r\n]+/", ' ', $data['subject'] ?? '')) ?: 'Không tiêu đề';
        $userMessage = $data['message'];

        $subject = 'Hỗ trợ "' . $userSubject . '"';

        $safeMessage = nl2br(e($userMessage));
        $html = <<<HTML
        <p>Coffee Shop nhận được liên hệ của bạn:</p>
        <p>“{$safeMessage}”</p>
        <p><em><strong>Nếu cần hỗ trợ thêm, hãy trả lời email này!</strong></em></p>
        HTML;

        Mail::html($html, function ($mail) use ($userEmail, $subject) {
            $mail->to($userEmail)
                ->subject($subject);
            // ->replyTo('support@yourshop.com'); // (tuỳ chọn) để khách reply
        });

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['ok' => true, 'message' => "Đã gửi email hỗ trợ tới {$userEmail}. Vui lòng kiểm tra hộp thư! Nếu không nhận được, vui lòng kiểm tra lại email đã nhập!"]);
        }

        return back()->with('success', "Đã gửi email hỗ trợ tới {$userEmail}. Vui lòng kiểm tra hộp thư!");
    }
}
