<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AppSetting;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $settings = AppSetting::pluck('value', 'key')->toArray();
        return view('setting.setting', compact('settings', 'user'));
    }

    public function updateGeneralSettings(Request $request)
    {
        try {
            DB::beginTransaction();

            // Update or create settings
            foreach ($request->settings as $key => $value) {
                AppSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            // Log activity
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id,
                'update',
                'Updated general settings'
            );

            DB::commit();
            return response()->json(['success' => 'Settings updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to update settings'], 500);
        }
    }

    public function updateMailSettings(Request $request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->settings as $key => $value) {
                AppSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            // Log activity
            $activityController = new ActivityController();
            $activityController->store(
                auth()->user()->id,
                'update',
                'Updated mail settings'
            );

            DB::commit();
            return response()->json(['success' => 'Mail settings updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to update mail settings'], 500);
        }
    }

    public function testMail(Request $request)
    {
        try {
            $request->validate([
                'test_email' => 'required|email'
            ]);

            $settings = AppSetting::pluck('value', 'key')->toArray();

            $mail = new PHPMailer(true);

            //Server settings
            $mail->isSMTP();
            $mail->Host       = $settings['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $settings['smtp_username'];
            $mail->Password   = $settings['smtp_password'];
            $mail->SMTPSecure = $settings['smtp_encryption'];
            $mail->Port       = $settings['smtp_port'];

            //Recipients
            $mail->setFrom($settings['mail_from_address'], $settings['mail_from_name']);
            $mail->addAddress($request->test_email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Test Email from ' . $settings['app_name'];
            $mail->Body    = view('emails.test')->render();

            $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->Debugoutput = function($str, $level) {
                \Log::info("PHPMailer debug: $str");
            };

            $mail->send();
            return response()->json(['success' => 'Test email sent successfully']);
        } catch (Exception $e) {
            \Log::error('Mail Error:', [
                'message' => $mail->ErrorInfo,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $mail->ErrorInfo], 500);
        }
    }
}