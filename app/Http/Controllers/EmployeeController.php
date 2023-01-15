<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use Exception;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('admin.employee.index', compact('companies'));
    }

    /** get all Employee **/

    public function getEmployee(){

     $data = Employee::with('company')->simplePaginate(10);

     if($data){

           return response()->json($data);

     }else{
        return response()->json([

                'status' => 500,
                'message' => 'Internal Server Error'
           ]);
     }

    

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {

        try{

            $store = Employee::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'company_id' => $request->company_id,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            if($store){
                    return response()->json([
                            'status' => 200,
                            
                    ]);
            }

        }catch(Exception $e){
             return response()->json([
                    'status' => 500,
                    'message' => $e->getMessage()
             ]);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $Employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Employee::find($id);

        if($data){
            return response()->json([

                'status' => 200,
                'data' => $data
  
            ]);
           
        }else{

             return response()->json([

                'status' => 500,
                'message' => 'Internal Server Error'
  
            ]);

        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $Employee)
    { 
        try{

               $update = Employee::where('id',$request->id)->update([
                            'first_name' => $request->first_name,
                            'last_name' => $request->last_name,
                            'company_id' => $request->company_id,
                            'email' => $request->email,
                            'phone' => $request->phone
                        ]);

            if($update){

                return response()->json([

                        'status' => 200,
                        
                ]);
            }else{

                return response()->json([

                        'status' => 404,
                        'message' => 'Not Found...!'
                ]);

            }

        }catch(Exception $e){
            
                return response()->json([

                        'status' => 500,
                        'message' => $e->getMessage()
                ]);
        }
    }
       

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $Employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Employee::find($id);
        if($data){
            $delete = $data->delete();
            if($delete){

                return response()->json([

                    'status' => 200,
                    'message' => 'Successfully deleted'

                ]);
            }
            else{

                 return response()->json([

                            'status' => 500,
                            'message' => 'Internal Server Error'

                    ]);
                }

            }else{

                return response()->json([

                            'status' => 404,
                            'message' => 'Not found...!'

                    ]);
                }
        

    }
}

