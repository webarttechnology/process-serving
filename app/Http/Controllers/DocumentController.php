<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\document;
use App\Models\order;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function save_document( Request $req )
    {
        $req->session()->put('step', 4);

                $order = order::find(session('order_id'));
                $order->step = 3;
                $order->save();
    }

    public function add_document(Request $req)
    {
        foreach ($req->input('u_title') as $index => $value) {
            $existingData = document::where('order_id', session('order_id'))
                ->where('case_no', session('case_id'))
                ->where('d_title', $req->input('d_title')[$index])
                ->first();

            if (!$existingData) {
                if ($req->ajax()) {
                    $model = new document();
                    $model->order_id = session('order_id');
                    $model->case_no = session('case_id');
                    $model->servee_id = $req->post('s_id')[$index];
                    if (isset($req->post('s_id')[$index])) {
                        $model->s_no = $req->post('s_id')[$index];
                    }
                    $model->d_t_u = $req->post('u_title')[$index];
                    $model->d_title = $req->post('d_title')[$index];
                    if ($req->hasFile('d_file')) {
                        $image = $req->file('d_file')[$index];
                        $ext = $image->extension();
                        $image_name = $req->post('u_title')[$index] . ' ' . $req->post('d_title')[$index] . '.' . $ext;
                        $image->move(public_path('/uploads'), $image_name);
                        $model->document = $image_name;
                    }
                    if (isset($req->post('s_d')[$index])) {
                        $model->s_d = $req->post('s_d')[$index];
                    }
                    $model->save();
                    return response()->json($model);
                }
                return abort(404);
            }
        }

        return true;
    }

    public function add(Request $req)
    {
        $s_no = $req->input('s_no');
        // $utitle = $req->input('utitle');
        $title = $req->input('title');
        $file = $req->file('file');
        $type = $req->input('type');
        $model = new document();
        $model->order_id = session('order_id');
        $model->case_no = session('case_id');
        $model->s_no = $s_no;
        $model->d_t_u = '';
        $model->d_title = $title;
        $model->type = $type;
        if ($req->hasFile('file')) {
            $image = $file;
            $ext = $image->extension();
            $image_name = $req->post('title') . '.' . $ext;
            $image->move(public_path('/uploads'), $image_name);
            $model->document = $image_name;
        }
        $model->save();
        $model['s_name'] = DB::table('serves')
            ->where(['order_id' => session('order_id'), 'id' => $s_no])
            ->first();
        return response()->json($model);
    }
    public function addd(Request $req)
    {
        // $s_no = $req->input('s_no');
        // $utitle = $req->input('utitle');
        $title = $req->input('title');
        $file = $req->file('file');
        $type = $req->input('type');
        $s_d = $req->file('s_d');
        $model = new document();
        $model->order_id = session('order_id');
        $model->case_no = session('case_id');
        // $model->s_no = $s_no;
        $model->d_t_u = '';
        $model->d_title = $title;
        $model->s_d = 'yes';
        $model->type = $type;
        if ($req->hasFile('file')) {
            $image = $file;
            $ext = $image->extension();
            $image_name = $req->post('title') . '.' . $ext;
            $image->move(public_path('/uploads'), $image_name);
            $model->document = $image_name;
        }
        $model->save();
        return response()->json($model);
    }

    public function del_document(Request $req, $id)
    {
        if ($req->ajax()) {
            $model = document::find($id);
            $model->delete();
            return true;
        }
        return abort(404);
    }

    public function getOptions(Request $request)
    {
        $category = $request->input('category');
        $options = DB::table('court_defined_documents')
            ->where('category', $category)
            ->pluck('document')
            ->toArray();

        return response()->json($options);
    }
}