<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use DB;
use Illuminate\Support\Facades\Storage;


class ShortUrlController extends Controller
{


    public function index()
        {

            $shortUrls = ShortUrl::latest()->paginate(10);

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
            $randomShortKey = null;
            }


            $input['short_key'] = $randomShortKey;
            $input['custom_short_key'] = $request->custom_short_key;

            $blackListFile = Storage::disk('local')->get('public/blacklist.txt');
            $blackListFileArray = explode("\n", $blackListFile);

            if (in_array( $customShortKey, $blackListFileArray))
            {
            return redirect('short-link')->with('success', "Sorry, you're trying to use a bad word. Try another one." );
            }


            $input['expired_at'] = time()+env('SHORT_URL_MAX_LIFE_TIME');

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
        $redirectTo = "";
        $expiredUrlDate = time();

            $findByShortKey = ShortUrl::where('short_key', $code)->first();

            if($findByShortKey){

            $redirectTo = $findByShortKey->url;
            $expiredUrlDate = $findByShortKey->expired_at;
            $findByShortKey->increment('clicks', 1);
            }

            $findByCustomShortKey = ShortUrl::where('custom_short_key', $code)->first();
            if($findByCustomShortKey){

            $redirectTo = $findByCustomShortKey->url;
            $expiredUrlDate = $findByCustomShortKey->expired_at;

            $findByCustomShortKey->increment('clicks', 1);
            }


            abort_if(time() >= $expiredUrlDate, 404);
            abort_if(!$redirectTo, 404);
            return redirect($redirectTo);
        }

    }


