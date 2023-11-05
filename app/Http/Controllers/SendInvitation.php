<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google\Client;
use App\Models\GoogleAccessToken;
use Exception;
use Mail;

class SendInvitation
{
    function sendEmailInvitation (Request $request){
        $validator = Validator::make($request->all(),[
            'emailTo'       => 'required|email',
            'emailFrom'     => 'required|email',
            'startDate'     => 'required|date',
            'endDate'       => 'required|date',
            'timezone'      => 'required|string',
            'message'       => 'required|string',
            'jobOfferId'    => 'required|string',
            'jobUrl'        => 'required|string',
            'employerId'    => 'required|string',
            'companyName'   => 'required|string',
            'applicantName' => 'required|string',
            'jobTitle'      => 'required|string',
            'employerName'  => 'required|string'
        ]);
        if($validator->fails())
        {
            return $this->sendError("Validation Error",$validator->errors());
        }

        $emailTo         = $request->emailTo;
        $emailFrom       = $request->emailFrom;
        $startDate       = $request->startDate;
        $endDate         = $request->endDate;
        $message         = $request->message;
        $timezone        = $request->timezone;
        $jobOfferId      = $request->jobOfferId;
        $jobUrl          = $request->jobUrl;
        $employerName    = $request->employerName;
        $employerId      = $request->employerId;
        $companyName     = $request->companyName;
        $requestId       = "empmeet".Carbon::now()->getTimeStamp();
        $startDateTime   = Carbon::parse($startDate)->format("Y-m-d\TH:i:s");
        $endDateTime     = Carbon::parse($endDate)->format("Y-m-d\TH:i:s");
        $starttimeformat = Carbon::parse($startDate)->format("Ymd\THis");
        $endtimeformat   = Carbon::parse($endDate)->format("Ymd\THis");
        $employerToken   = GoogleAccessToken::where('employer_id', $employerId)->latest()->first();
        
        if(!$employerToken){
            return $this->response(false, [], [], 'Employer does not exist', 400,[]);
        }
        
        $client       = $this->getClient($employerId);
        $service      = new Google_Service_Calendar($client);
        $calendarId   = "";
        try {
            $calendarList = $service->calendarList->listCalendarList();
            foreach ($calendarList->getItems() as $calendar) {
                if($calendar['accessRole'] == 'owner' && $calendar['primary']){
                    $calendarId = $calendar->id;
                }
            }
        } catch (Exception $e) {
            $employerToken->update(['is_expired' => true]);
            $data = new Request ([
                "email_to"   => $emailFrom,
                "from_email" => env('MAIL_USERNAME'),
                "from_name"  => "Add from name",
                "subject"    =>  "Subject Title for reauthentication",
                'payload'    => array( 
                    'template'     => 'emails.authenticate',
                )
            ]);

            $this->sendEmail($data);
            return $this->response(true,[], $e, 'Email is send successfully');
        }

        $employerToken->update(['employer_email' => $calendarId]);
        
        $event = new Google_Service_Calendar_Event([
                    'start'          => ['dateTime' => $startDateTime,'timeZone' => $timezone],
                    'end'            => ['dateTime' => $endDateTime,'timeZone' => $timezone],
                    'conferenceData' => ['createRequest' => ['requestId' => $requestId,'conferenceSolutionKey' => ['type' => 'hangoutsMeet']]],
                    'summary'        => "Interview with ".$companyName." — Oliv",
                    'description'    => $message
                ]);

        $eventCreated = $service->events->insert($calendarId, $event, array('conferenceDataVersion' => 1));
        $googleMeet   = $eventCreated->conferenceData->entryPoints[0]->uri;
        
        $filename     = "invite.ics";
        $fileTemp     = 'temp_invite.ics';
        $fileContents = file_get_contents($fileTemp);
        $fileContents = str_replace('{{timezone}}', $timezone, $fileContents);
        $fileContents = str_replace('{{start_date_time}}', $starttimeformat, $fileContents);
        $fileContents = str_replace('{{end_date_time}}', $endtimeformat, $fileContents);
        $fileContents = str_replace('{{attendee_email}}', $emailTo, $fileContents);
        $fileContents = str_replace('{{email_from}}', $emailFrom, $fileContents);
        $fileContents = str_replace('{{meet_link}}', $googleMeet, $fileContents);
        $fileContents = str_replace('{{summary}}', "Interview with ".$companyName." — Oliv", $fileContents);
        $fileContents = str_replace('{{description}}', $message, $fileContents);
        $fileContents = str_replace('{{request_id}}', $requestId, $fileContents);

        file_put_contents($filename, $fileContents);
        $data = new Request ([
            "email_to"   => $emailTo,
            "from_email" => env('MAIL_USERNAME'),
            "from_name"  => "Add from name",
            "subject"    =>  "Subject for invitation",
            'attach'     => "invite.ics",
            'payload'    => array( 
                'template'     => 'emails.invitation',
            )
        ]);
        $this->sendEmail($data);
        return $this->response(true,[], [], 'Email is send successfully');
        
    }
    
    function getClient($employerId)
    {
        $credentials =  $credentials =  base_path().'\credentials.json';
        $client = new Client();
        $client->setApplicationName( env('GOOGLE_APPLICATION_NAME'));
        $client->setScopes('https://www.googleapis.com/auth/calendar');
        $client->setAuthConfig($credentials);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $employerToken = GoogleAccessToken::where("employer_id",$employerId)->select('access_token','expires_in','refresh_token','created','token_type')->latest()->first();
        $token = [
                "access_token"  => $employerToken->access_token,
                "expires_in"    => $employerToken->expires_in,
                "refresh_token" => $employerToken->refresh_token,
                "created"       => $employerToken->created,
                "token_type"    => $employerToken->token_type,
                "scope"         => "https://www.googleapis.com/auth/calendar"
        ];
        $token = json_encode($token);
        $client->setAccessToken($token);
        return $client;
    }

    public function getUrl(){
        $credentials =  base_path().'\credentials.json';
        $client = new Client();
        $client->setApplicationName( env('GOOGLE_APPLICATION_NAME'));
        $client->setScopes('https://www.googleapis.com/auth/calendar');
        $client->setAuthConfig($credentials);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $authUrl = $client->createAuthUrl();
        return $this->response(true, $authUrl, [], 'URL is generated', 200,[]);
    }
    
    public function getToken(Request $request){
        $validator = Validator::make($request->all(),[
            'employerId'     => 'required|string'
        ]);
        if($validator->fails())
        {
            return $this->sendError("Validation Error",$validator->errors());
        };
        $credentials =  base_path().'\credentials.json';
        $client = new Client();
        $client->setApplicationName( env('GOOGLE_APPLICATION_NAME'));
        $client->setScopes('https://www.googleapis.com/auth/calendar');
        $client->setAuthConfig($credentials);
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $code           = $request->code;
        $employerId     = $request->employerId;
        
        if(isset($code))
        {
            $accessToken = $client->fetchAccessTokenWithAuthCode($code);
            if(isset($accessToken['error'])){
                return $this->response(false, [], $accessToken, 'Code is incorrect', 400);
            }
            else{
                $employer = GoogleAccessToken::create([
                    'employer_id'   => $employerId,
                    'access_token'  => $accessToken['access_token'],
                    'refresh_token' => $accessToken['refresh_token'],
                    'token_type'    => $accessToken['token_type'],
                    'expires_in'    => $accessToken['expires_in'],
                    'created'       => $accessToken['created']
                ]);

                if(!$employer){
                    return $this->response(false, [], [], 'Something bad happen', 400);
                }
                $client->setAccessToken($accessToken);
                return $this->response(true, ["access_token" => $accessToken['access_token']],[], 'Access token successfully created', 200);
            }
        }
        else{
            $employerToken = GoogleAccessToken::where("employer_id",$employerId)->latest()->first();
            
            if(!$employerToken)
                return $this->response(false,[] , [], 'Employer does not exist',404);

            $token = [
                "access_token"  => $employerToken->access_token,
                "expires_in"    => $employerToken->expires_in,
                "refresh_token" => $employerToken->refresh_token,
                "created"       => $employerToken->created,
                "token_type"    => $employerToken->token_type,
            ];
            $token = json_encode($token);

            $client->setAccessToken($token);
            if ($client->isAccessTokenExpired()) {
                if ($client->getRefreshToken()) {
                    $updatedToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    $employerToken->update([
                        'access_token'  => $updatedToken['access_token'],
                        'refresh_token' => $updatedToken['refresh_token'],
                        'token_type'    => $updatedToken['token_type'],
                        'expires_in'    => $updatedToken['expires_in'],
                        'created'       => $updatedToken['created']
                    ]);
                    return $this->response(true, ["access_token" => $updatedToken['access_token']],[], 'Access token successfully created');
                } 
            }
            return $this->response(true,["access_token" => json_decode($token)->access_token],[], 'Get access token successfully');
            
        }
    }

    function isExpired(Request $request){
        $validator = Validator::make($request->all(),[
            'employerId' => 'required|string'
        ]);
        if($validator->fails())
        {
            return $this->sendError("Validation Error",$validator->errors());
        };

        $employerToken = GoogleAccessToken::where("employer_id",$request->employerId)->latest()->first();
        if($employerToken && $employerToken->is_expired == false){
            return $this->response(false,[] , [], [],404);
        }
        else{
            return $this->response(true,[] , [], []);
        }
    }

    public function response($success, $data, $errors,$msg,$code = 200,$pagination=[])
    {
        $data = [
            'success' => $success,
            'data'    => $data,
            'message' => $msg,
            'paging'  => $pagination,
            'errors'  => $errors
        ];
        return response()->json($data, $code, ['Content-type'=> 'application/json; charset=utf-8'], JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_UNICODE);
    }

    public function sendEmail(Request $req){

        
        $to         = $req->email_to;
        $from_email = $req->from_email;
        $from_name  = $req->from_name;
        $subject    = $req->subject;
        $attach     = $req->attach;
        $cc         = $req->cc;
        $template   = $req->payload['template'];
        Mail::mailer()->send(["html" =>$template],[],function($mail) use ($to,$from_email,$from_name,$cc,$subject,$attach){
            $mail->to($to);
            $mail->from($from_email,$from_name);
            if($cc)
            {
                $mail->cc($cc);
            }
            $mail->subject($subject);
            if($attach){
                $mail->attach('invite.ics', array(
                    'as' => 'invite.ics', 
                    'mime' => "text/html"));
            }
        });                     
    }
}