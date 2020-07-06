<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Master\Vendor;
use TJGazel\Toastr\Facades\Toastr;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
    *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Vendor();
        $data->name = $request->name;
        $data->address = $request->address;
        $data->cp = $request->contactPerson;
        $data->phone = $request->phone;
        $data->active = $request->status;
        $data->user_modified = Auth::user()->id;

        if($data->save()){
            Toastr::success('Vendor Created Successfully'. 'Success');
            return redirect()->route('vendor.index');
        }
        else{
            Toastr::error('Vendor Created Successfully'. 'Success');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function datatable(){

        $data = Vendor::all();
        return DataTables::of($data)
                ->addColumn('action', function($data){
                    $url_edit = url('master/vendor/'.$data->id.'/edit');
                    $url = url('master/vendor/'.$data->id);
                    $view = " <a class='btn btn-action btn-primary' 
                                href='".$url."' title='View'>
                                <i class='nav-icon fas fa-eye'></i>
                                </a> ";
                    $edit = " <a class='btn btn-action btn-warning' 
                                href='".$url_edit."' title='Edit'>
                                <i class='nav-icon fas fa-edit'></i>
                                </a> ";
                    $delete = "<button data-url='".$url."' onclick='deleteData(this)' 
                                class='btn btn-action btn-danger' title='Delete'> 
                                <i class='nav-icon fas fa-trash-alt'></i> 
                                </button>";
                
                    return $view."".$edit."".$delete;
                })
                ->editColumn('address', function($data){
                    return str_ireplace("\r\n",',',$data->address);

                })
                ->editColumn('address', function($data){
                    return str_ireplace("\r\n",',',$data->phone);
                })
                ->rawColumns(['action'])
                ->editColumn('id', 'ID:{{$id}}')
                ->make(true);

    }
}
