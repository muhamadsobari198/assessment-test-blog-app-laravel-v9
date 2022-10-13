<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

use Exception;

use App\Models\User;
use App\Models\Article;

class ArticleController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                                  FrontEnd                                  */
    /* -------------------------------------------------------------------------- */




    /* -------------------------------------------------------------------------- */
    /*                                 Admin Panel                                */
    /* -------------------------------------------------------------------------- */

    public function main()
    {
        return view('admin.master.article');
    }

    public function store(ArticleRequest $request)
    {

        $user = User::where('token', $request->bearerToken())->first();

        $otherRules = ['file'  => 'required|file|mimes:jpeg,png,jpg,gif|max:2048'];
        $request->validate($otherRules);

        try {

            $request['created_by'] = $user->id;

            if($request->file('file')) {
                $request['image'] = __uploadFile(
                    $request->file('file'),
                    'public'
                );
            }

            $article = Article::create($request->except('file'));
            
            Cache::flush();

            return response()->json([
                'status' => true,
                'message' => 'Article berhasil ditambahkan.',
                'data'    => $article
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Terdapat kesalahan pada sistem internal.',
                'error'   => $e->getMessage()
            ], 500);

        }

    }

}
