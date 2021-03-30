<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class App extends Model
{

    protected $table = 'app';

    protected $fillable = [];

    protected $hidden = [];

    public static function fetchAllLocationOptions(){

        $result = DB::table('app')
            ->select('locations')
            ->get();

        $cityArray = array();

        $countries = json_decode($result[0]->locations);

        foreach($countries as $country){
            foreach($country->regions as $region){
                foreach($region->cities as $city){
                    array_push($cityArray,$city);
                }
            }
        }

        return $cityArray;
    }

    public static function fetchLocationOptionsByLetter($letter){

        $result = DB::table('app')
            ->select('locations')
            ->get();

        $countries = json_decode($result[0]->locations);

        $letter = strtoupper($letter);
        $cityArray = array();

        foreach($countries as $country){
            foreach($country->regions as $region){
                foreach($region->cities as $city){
                    if($city[0] === $letter){
                        array_push($cityArray,$city);
                    }
                }
            }

        }

        return $cityArray;
    }

    public static function insertAppLocations(){

        $locations = '[{"country":"England","regions":[{"region":"North East","cities":["Northumberland","Newcastle upon Tyne","Gateshead","North Tyneside","South Tyneside","Sunderland","County Durham","Darlington","Hartlepool","Stockton-on-Tees","Redcar and Cleveland","Middlesbrough"]},{"region":"North West","cities":["Cheshire","Halton","Warrington","Barrow-in-Furness","South Lakeland","Copeland","Allerdale","Eden","Carlisle","Bolton","Bury","Manchester","Oldham","Rochdale","Salford","Stockport","Tameside","Trafford","Wigan","West Lancashire","Chorley","South Ribble","Fylde","Preston","Wyre","Lancaster","Ribble Valley","Pendle","Burnley","Rossendale","Hyndburn","Blackpool","Blackburn","Knowsley","Liverpool","St. Helens","Sefton","Wirral"]}]},{"country":"Scotland","regions":[{"region":"Dumfries and Galloway","cities":["Dumfries"]}]}]';
        $result = DB::table('app')
            ->insert(['locations' => $locations]);

        $result = DB::table('app')
            ->select('locations')
            ->get();

        $countries = json_decode($result[0]->locations);

        $letter = "D";
        $letter = strtoupper($letter);
        $cityArray = array();

        foreach($countries as $country){
            foreach($country->regions as $region){
                foreach($region->cities as $city){
                    if($city[0] === $letter){
                        array_push($cityArray,$city);
                    }
                }
            }

        }

        dd($cityArray);

    }
}

