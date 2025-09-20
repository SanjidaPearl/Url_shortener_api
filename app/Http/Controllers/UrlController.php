<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UrlController extends Controller
{
    //
    public function index(){
        if (!Auth::check()) {
        return response()->json([
            'status'  => false,
            'message' => 'Unauthorized. Please log in first.'
        ], 401);
        }
        $urls = Url::where('user_id',Auth::id())->get();
        return response()->json([
            'status'=>true,
            'data'=>$urls
        ]);
    }
    private function idToShortCode($id) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($characters);
        $shortCode = '';
        while ($id > 0) {
            $shortCode = $characters[$id % $base] . $shortCode;
            $id = floor($id / $base);
        }
        return $shortCode;
    }
    public function shorten(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

    
        $url = Url::create([
            'user_id' => Auth::id(),
            'original_url' => $request->original_url,
            'short_code' => '' // placeholder
        ]);

        // Step 2: Generate short code from ID
        $shortCode = $this->idToShortCode($url->id);

        // Step 3: Update record with short code
        $url->short_code = $shortCode;
        $url->save();

        return response()->json([
            'status'  => true,
            'message' => 'URL shortened successfully',
            'data'    => [
                'original_url' => $url->original_url,
                'short_url'    => url('/s/' . $url->short_code),
                'visits'       => $url->visits,
            ]
        ], 201);
    }
    public function redirect($code)
    {
        $url = Url::where('short_code', $code)->firstOrFail();
        $url->increment('visits');
        return redirect()->away($url->original_url);
    }


}
