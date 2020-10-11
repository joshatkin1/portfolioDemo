<?php

namespace App\Models;

use App\Mail\VerificationCodeEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccountDeviceVerification extends Model
{
    use HasFactory;

    protected $table = 'account_verification_code';
    protected $primaryKey = 'id';
    protected $id;
    protected $verificationCode;

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

        $cookieKey = substr(str_shuffle(str_repeat($x='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 3 )),1,15);
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
     * LIMITS VERIFICATION CODES TO 1 EVERY 10 MINS
     * @return bool
     */
    final public function limitVerificationCodes(){

        $last_code = DB::table($this->table)
            ->where('user' , '=' , session('id'))
            ->orderByDesc('created_time')
            ->first();

        if($last_code){
            $time_limit = time() - 600;

            if($last_code->created_time > $time_limit){
                return false;
            }
        }

        return true;
    }
}
