<?php

namespace App\Models;

use App\Mail\VerificationCodeEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountDeviceVerification extends Model
{
    use HasFactory;

    protected $table = 'account_verification_code';
    protected $primaryKey = 'id';
    protected $id;
    protected $verificationCode;

    protected $casts = [
        'verified_device_keys' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->id = session('id');
    }

    /**
     * CREATE VERIFICATION CODE AND LOG IN DATABASE
     * @return false|string
     */
    final public function createVerificationCode(){
        $time = time();
        $this->verificationCode = substr(str_shuffle(str_repeat($x='0123456789', 6 )),1,6);

        $code = DB::table($this->table)
            ->insert([
                'user' => session('id'),
                'code' => $this->verificationCode,
                'created_time' => $time,
            ]);

        return $this->verificationCode;
    }

    /**
     * FETCH ACCOUNT DEVICE VERIFICATION CODES
     * @return \Illuminate\Support\Collection
     */
    final public function fetchAccountVerificationCodes(){
        $timeLimit = time() - 1800000;
        $codes = DB::table($this->table)
            ->select('code')
            ->where('user', '=', $this->id)
            ->where('created_time', '>', $timeLimit)
            ->get();

        return $codes;
    }

    /**
     * ADD DEVICE KEY TO USER ACCOUNT ALLOWED DEVICES
     * @return bool
     */
    final public function addThisDeviceToVerifiedList(){

        $cookieKey = Str::random(32);
        $key = $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $cookieKey;
        $deviceHash = Hash::make($key);

        $verifiedDevices = DB::table('users')
            ->pluck('verified_device_keys')
            ->where('id' , '=' , session('id'));

        $verifiedDevices = json_decode($verifiedDevices);

        array_push($verifiedDevices, $deviceHash);

        DB::table('users')
            ->where('id', '=', session('id'))
            ->update(['verified_device_keys' => $verifiedDevices]);

        return $cookieKey;
    }

    /**
     * CREATES STORES AND FORMATS THE VERIFICATION CODE FOR THE EMAIL
     * @return string
     */
    final public function formatVerificationCode(){
        $code = $this->createVerificationCode();
        $code = substr($code,0,3) . ' ' .  substr($code,3,4);
        return $code;
    }

    /**
     * LIMITS VERIFICATION CODES TO 3 EVERY 1 MINUTE
     * @return bool
     */
    final public function limitVerificationCodes(){

        $time_limit = time() - 60;

        $result = DB::table($this->table)
            ->where('user' , '=' , session('id'))
            ->where('created_time', '>', $time_limit)
            ->get();

        if($result){
            if(count($result) > 2){
                return false;
            }
        }

        return true;
    }
}
