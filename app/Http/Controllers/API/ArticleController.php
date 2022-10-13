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

    
    protected function articleTable($type= "search", $start, $limit, $order, $dir, $search = '') {
        if($type == 'search') {

            return Article::select(
                'articles.*',
                'users.name'
            )
            ->leftJoin('users', 'users.id', '=', 'articles.created_by')
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('id', 'LIKE', "%{$search}%")
            ->orWhere('content', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        } else{

            return Article::select(
                'articles.*',
                'users.name'
            )
            ->leftJoin('users', 'users.id', '=', 'articles.created_by')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        }
    }


    public function dataTable(Request $request)
    {
        try {
            $columns = ['id', null,'title', 'content', 'created_by', 'created_at', 'updated_at'];

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data          = array();
            $totalData     = Article::count();
            $totalFiltered = $totalData;
            $posts	       = '';


            if(!empty($request->input('search.value'))) {
                
                $search = $request->input('search.value');

                $posts = Cache::remember('article:all'.$start.''.$search, 10, function () use ($start, $limit, $order, $dir, $search ) {
                    return $this->articleTable('search', $start, $limit, $order, $dir, $search);
                });
                

                $totalFiltered = count($posts);

            } else {

                $posts = Cache::rememberForever('article:all'.$start, function () use ($start, $limit, $order, $dir ) {
                    return $this->articleTable('others', $start, $limit, $order, $dir);
                });

            }

            if (!empty($posts)) {
                $no  = $start + 1;
                $row = 0;

                foreach ($posts as $a) {
                    $d['no']         = $no++;
                    $d['id']   = $a['id'];
                    $d['image'] = $a['image'];
                    $d['title'] = $a['title'];
                    $d['content'] = $a['content'];
                    $d['created_by'] = $a->createdBy->name;
                    $d['created_at'] = date($a['created_at']);
                    $d['updated_at'] = date($a['updated_at']);
                    $row++;
                    $data[] = $d;

                }
            }

            $json_data = array("draw" => intval($request->input('draw')), "recordsTotal" => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $data);

            return json_encode($json_data);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terdapat kesalahan pada sistem internal.',
                'error'   => $e->getMessage()
            ], 500);
        }
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


    public function update(ArticleRequest $request, $id)
    {
      
        $otherRules = [];

        if($request->file('file')) {
            $otherRules['file'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $request->validate($otherRules);

        try {

            $article = Article::where('id', $id);
            
            if($request->file('file')) {

                __deleteFile($article->first()->image);

                $request['image'] = __uploadFile(
                    $request->file('file'),
                    'public'
                );

            }

            Cache::flush();

            $article->update($request->except('file'));

            return response()->json([
                'status' => true,
                'message' => 'Article berhasil diperbarui.',
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Terdapat kesalahan pada sistem internal.',
                'error'   => $e->getMessage()
            ], 500);

        }
    }

    public function delete($id)
    {

        try {
            
            $article = Article::where('id', $id);

            __deleteFile($article->first()->image);

            $article->delete();

            Cache::flush();
            

            return response()->json([
                'status' => true,
                'message' => 'Article berhasil dihapus.',
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
