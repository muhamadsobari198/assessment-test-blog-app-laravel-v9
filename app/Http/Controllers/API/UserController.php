<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    
    public function index()
    {
        return view('admin.master.user');
    }

    
    protected function userTable($type= "search", $start, $limit, $order, $dir, $search = '') {
        if($type == 'search') {

            return User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('id', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        } else{

            return User::offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        }
    }


    public function dataTable(Request $request)
    {
        try {
            $columns = ['id', 'name','email', 'role', 'created_at', 'updated_at'];

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data          = array();
            $totalData     = User::count();
            $totalFiltered = $totalData;
            $posts	       = '';


            if(!empty($request->input('search.value'))) {
                
                $search = $request->input('search.value');

                $posts = Cache::remember('users:all'.$start.''.$search, 10, function () use ($start, $limit, $order, $dir, $search ) {
                    return $this->userTable('search', $start, $limit, $order, $dir, $search);
                });
                

                $totalFiltered = count($posts);

            } else {

                $posts = Cache::rememberForever('users:all'.$start, function () use ($start, $limit, $order, $dir ) {
                    return $this->userTable('others', $start, $limit, $order, $dir);
                });

            }

            if (!empty($posts)) {
                $no  = $start + 1;
                $row = 0;

                foreach ($posts as $a) {
                    $d['no']         = $no++;
                    $d['id']   = $a['id'];
                    $d['name'] = $a['name'];
                    $d['email'] = $a['email'];
                    $d['role'] = $a['role'];
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


    public function store(UserRequest $request)
    {

        try {

            $request['password'] = Hash::make('password');
            
            $user = User::create($request->all());
            
            Cache::flush();

            return response()->json([
                'status' => true,
                'message' => 'User berhasil ditambahkan.',
                'data'    => $user
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Terdapat kesalahan pada sistem internal.',
                'error'   => $e->getMessage()
            ], 500);

        }

    }


    public function update(UserRequest $request, $id)
    {
      
        try {

            $user = User::where('id', $id);
            
            Cache::flush();

            $user->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'User berhasil diperbarui.',
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
            
            $user = User::where('id', $id);
            $user->delete();

            Cache::flush();

            return response()->json([
                'status' => true,
                'message' => 'User berhasil dihapus.',
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
