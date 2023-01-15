<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Exception;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.company.index');
    }

    /** get all company **/

    public function getCompany(){

     $data = Company::simplePaginate(10);

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
    public function store(CompanyRequest $request)
    {

        try{

            if($request->hasFile('logo')){
                $file = $request->logo;
                $newName = time().'.'.$file->getClientOriginalExtension();
                $file->storeAs('public/company', $newName);

            }

            $store = Company::create([
                'name' => $request->name,
                'email' => $request->email,
                'logo' => $request->logo ? $newName : '',
                'website' => $request->website
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
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Company::find($id);

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
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    { 
        try{

            $data = Company::find($request->id);
            if($data){

                $data->name = $request->name;
                $data->email = $request->email;
                if($request->hasFile('logo')){

                    $file = $request->logo;
                    $newName = time().'.'.$file->getClientOriginalExtension();
                    $file->storeAs('public/company', $newName);
                    $data->logo = $newName;
                }

                $data->website = $request->website;

                $data->save();

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
            

        }
    }
       

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Company::find($id);
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
