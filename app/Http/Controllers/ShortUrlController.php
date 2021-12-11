<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use DB;

class ShortUrlController extends Controller
{
    public function index()
        {

  //            $shortUrlMaxLifeTime = env("SHORT_URL_MAX_LIFE_TIME");

 //                $currentTime = time();

  //               $createdAt = DB::table('short_urls')->select('created_at')->get();

                 //$expiredTime = $shortUrlMaxLifeTime+$createdAt;
//dd($expiredTime);

//                 // DATE_ADD(created_at, INTERVAL 30 SECOND) >= NOW()
//                             $tmp = DB::table('short_urls')->select("created_at")->where('created_at', '', '')->get();
//                             dd($tmp);

            $shortUrls = ShortUrl::latest()->get();

            return view('shortener', compact('shortUrls'));
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $request->validate([
               'url' => 'required|url'
            ]);

            $input['url'] = $request->url;
            $customShortKey = $request->custom_short_key;

            // if $customShortKey isset
            if(!$customShortKey){
            $randomShortKey = ShortUrl::generateRandomString();
            }else{
            $randomShortKey = "";
            }

            $input['short_key'] = $randomShortKey;

            $input['custom_short_key'] = $request->custom_short_key;

            ShortUrl::create($input);


            return redirect('short-link')
                 ->with('success', 'Short Url Created Successfully!');
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function shortenUrl($code)
        {
        $redirectTo = "/";

            $findByShortKey = ShortUrl::where('short_key', $code)->first();

            if($findByShortKey){
            $redirectTo = $findByShortKey->url;
            $findByShortKey->increment('clicks', 1);
            }

            $findByCustomShortKey = ShortUrl::where('custom_short_key', $code)->first();
            if($findByCustomShortKey){
            $redirectTo = $findByCustomShortKey->url;
            $findByCustomShortKey->increment('clicks', 1);
            }

            return redirect($redirectTo);
        }



    }

