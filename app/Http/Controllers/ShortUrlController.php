<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use DB;
use Illuminate\Support\Facades\Storage;


class ShortUrlController extends Controller
{
    // showing us the form and the table with urls
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
         // saving input values into the db
        public function store(Request $request)
        {
            $request->validate([
               'url' => 'required|url'
            ]);
            // we get a long url
            $input['url'] = $request->url;
           // we get a custom short key
            $customShortKey = $request->custom_short_key;

            // if $customShortKey !isset, we generate a random short key with the function from the model
            if(!$customShortKey){
            $randomShortKey = ShortUrl::generateRandomString();
            }else{
            $randomShortKey = null; // we cannot insert a blank string
            }

            $input['short_key'] = $randomShortKey;
            $input['custom_short_key'] = $request->custom_short_key;

            $blackListFile = Storage::disk('local')->get('public/blacklist.txt');
            $blackListFileArray = explode("\n", $blackListFile); // we turn the content of a txt file into an array

            if ($customShortKey && in_array($customShortKey, $blackListFileArray))
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

            $findByShortKey = ShortUrl::where('short_key', $code)->first(); // to retrieve a single row from a database table, DB facade's first method. This method will return a single stdClass object

// to have one columns with # of clicks, we need to define whether the clicked url has a custom or random short key
            if($findByShortKey){

            $redirectTo = $findByShortKey->url;
            $expiredUrlDate = $findByShortKey->expired_at;
            $findByShortKey->increment('clicks', 1);
            }

            $findByCustomShortKey = ShortUrl::where('custom_short_key', $code)->first(); // to retrieve a single row from a database table, DB facade's first method. This method will return a single stdClass object

            if($findByCustomShortKey){

            $redirectTo = $findByCustomShortKey->url;
            $expiredUrlDate = $findByCustomShortKey->expired_at;

            $findByCustomShortKey->increment('clicks', 1); // we add +1 to the number that is in the table
            }


            abort_if(time() >= $expiredUrlDate, 404);
            abort_if(!$redirectTo, 404);
            return redirect($redirectTo);
        }

    }


