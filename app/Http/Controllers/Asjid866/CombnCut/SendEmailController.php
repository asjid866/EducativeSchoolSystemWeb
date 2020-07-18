<?php
/**
 * Created by PhpStorm.
 * User: b
 * Date: 05/07/2020
 * Time: 03:07 PM
 */

namespace App\Http\Controllers\Asjid866\CombnCut;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


class SendEmailController extends BaseController
{
    function sendNewBookedEmailToAdmin(){
//        dump("email sent");
//        die;

//        $data = array(
//            'name'      =>  $request->name,
//            'message'   =>   $request->message
//        );


        $data = array(
            'name'      =>  "Asjid Yasin",
            'message'   =>   "This is test email"
        );


        $tomail = "asjid866@gmail.com";
        $toname = "Asjid Yasin";

//        Mail::send('combncut_email_template', $data, function ($message) use ($toname, $tomail){
//            $message->to($tomail)
//                ->subject('Test Email');
//        } );

        Mail::to('asjid866@gmail.com')->send(new SendMail($data));

        dump("email sent");
        die;

    }


}