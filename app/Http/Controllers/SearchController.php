<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function search(Request $request)
    {
        $id = $request->input('id');
        $data = DB::table('persons')->where(['id' => $id])->get(); 
        if(count($data) > 0){
            $check = DB::table('persons')->select('credits')->where(['id' => $id])->get();
            foreach($check as $val){
                $credits = $val->credits;
            }
            if($credits < 1){
                return response(array(
                            "Message" => "You dont have enough credits for the search",
                            'status' => 'credits'
                    ));
            }else{ 
        $cert = $request->input('cert');
        

        if(strlen($cert) > 0){
             
             $check = DB::table('info')->where(['Cert' => $cert])->get();
             if(count($check) > 0){
                for($i=0; $i<count($check); $i++){
                $datas = DB::table('info')->select('Name', 'School', 'Year', 'Code', 'Index', 'Cert')->where(['Cert' => $cert])->get();
                
                foreach($datas as $data){
                        $name = $data->Name;
                        $school = $data->School;
                        $year = $data->Year;
                        $code = $data->Code;
                        $index = $data->Index;
                        $cert = $data->Cert;
                       }
                // if($request->session()->has('FirstName')){
                //             $data=$request->session()->get('FirstName');  
                //         }
                return response(array(
                    'results' =>$datas->toArray(), 
                    ),200);
                    }
             }else{
            return response(array(
                "Message" => "This certificate number does not exist",
                "code" => 209,
                "status" => "no-match",
                
             ));
             }
        }else{
              return response(array(
                "Message" => "Please enter cert number to proceed",
                "code" => 209,
                "status" => "fail",
             ));
            
           }
          }
         }else{
            return response(array(
                "Message" => "This user does not exist",
                "code" => 209,
                "status" => "fail",
             ));
         }
        
        }
       
    public function getId(Request $request){
        $name = $request->input('name');
        $data = DB::table('persons')->where(['FirstName' => $name])->get();
        if(count($data) > 0){
            $check = DB::table('persons')->select('id')->where(['FirstName' => $name])->get();
            foreach($check as $val){
                $id = $val->id;
            }
         
        $data = DB::table('persons')->where(['id' => $id])->get();
        if(count($data) > 0){
            $check = DB::table('persons')->select('credits')->where(['id' => $id])->get();
            foreach($check as $val){
                $credits = $val->credits;
            }
            if($credits < 1){
                
            }else{
                return response(array(
                            "Message" => "You have enough credits for the search",
                            'status' => 'credits'
                            ));
        }
    }
        }
    }

   


    public function history(Request $request){
        $school = $request->input('school');
        $name = $request->input('name');
        $index = $request->input('index');
        $code = $request->input('code');
        $year = $request->input('year');
        $status = $request->input('status');
        $person_id = $request->input('person_id');
        $created_at = $request->input('created_at');

        $add[] = ['Name' => $name, 'School' => $school, 'index' => $index, 'code' => $code, 'year' => $year, 'status' => $status, 'person_id' => $person_id, 'created_at' => $created_at];
        if(!empty($add)){
            DB::table('historys')->insert($add);
            return response(array(
                "Message" => "Data inserted correctly",
                "code" => 209,
                "status" => "success",
             ));
        }else{
            return response(array(
                "Message" => "Data not inserted",
                "code" => 209,
                "status" => "fail",
             ));
        }
    }

    public function historyData(Request $request){
        
        $person_id = $request->input('person_id');
        
        $values = DB::table('historys')->where(['person_id' => $person_id])->get();
        for($i=0; $i<count($values); $i++){
         $check = DB::table('historys')
                ->select('school', 'name', 'year', 'index', 'code', 'status', 'cert', 'created_at')->where(['person_id' => $person_id])
                ->orderBy('id', 'desc')
                ->get();
        foreach($check as $checks){
            $school = $checks->school;
            $name = $checks->name;
            $index = $checks->index;
            $year = $checks->year;
            $code = $checks->code;
            $status = $checks->status;
            $cert = $checks->cert;

        }
        return response(array(
                    'results' =>$check->toArray(), 
                    ),200);

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
}
