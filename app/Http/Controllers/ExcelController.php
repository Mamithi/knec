<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bulk;
use App\View;
use DB;
use Session;

class ExcelController extends Controller
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






   public function deleteExcel(){
    DB::table('views')->delete();
   }


    public function importExcel(Request $request){

         $data =$request->input('Sheet1');
         $length = count($data);
         for($i = 0; $i < $length; $i++){
            $id = $data[$length-1];
          }

        
        $dataId = DB::table('persons')->where(['id' => $id])->get(); 
        if(count($dataId) > 0){
            array_pop($data); 
            $check = DB::table('persons')->select('credits')->where(['id' => $id])->get();
            foreach($check as $val){
                $credits = $val->credits;
            }
            if($credits < 1){
                return response(array(
                            "Message" => "You have no credits. Please buy new credits to continue",
                            'status' => 'noCredits'
                    ));
            }else{
        
         $length = count($data);
         if($length > $credits){
            return response(array(
                     "Message" => "Your credits are not enough for this search. You are searching for ".$length." records and you have ". $credits. " credits. Please buy more credits to continue",
                     'status' => 'lessCredits'
                    ));
         }else{
                
         if(count($data) >0){
            foreach($data as $values){ 
                    

                    $cert = $values['cert'];
                         $search = DB::table('info')->where(['Cert' => $cert])->get();
                         if(count($search)>0){
                            $status = "Verified";
                            $datas = DB::table('info')->select('Name', 'Cert', 'School','Index', 'Year', 'code')->where(['Cert' => $cert])->get(); 
                                    foreach ($datas as $data)
                                    {
                                        $schoolVar =  $data->School;
                                        $codeVar = $data->Code;
                                        $indexVar = $data->Index;
                                        $yearVar = $data->Year;
                                        $nameVar = $data->Name;
                                        $certVar = $data->Cert;
 
                                       
                                        //$person_id = $personId;
                                        $status = "Verified";
                                        $add[] = ['Name' => $nameVar, 'Cert' => $certvar, 'School' => $schoolVar, 'Code' => $codeVar, 'Year' => $yearVar, 'Index' => $indexVar,  'status' => $status];

                                      }
                                      }else{
                                        $status = "Does not exist";
                                        $certVar =  $cert;
                                        $codeVar = "null";
                                        $nameVar = "null";
                                        $yearVar = "null";
                                        $indexVar = "null";
                                        //$person_id = $personId;
                                       
                                        $add[] = ['Name' => $nameVar, 'School' => $schoolVar, 'Code' => $codeVar, 'Cert' => $certVar,  'Year' => $yearVar, 'Index' => $indexVar, 'status' => $status];
                                         }
                                    
                    
                   
            }
              
         }
        
         
         if(!empty($add)){
            DB::table('views')->insert($add);
            return response(array(
                                "Message" => "Your Data has been uploaded successfully",
                                "code" => 200,
                                "status" => "success",
                                
                   ));
             //$this->downloadExcel(); 
        }else{
            return response(array(
                                "Message" => "Data upload has failed",
                                "code" => 200,
                                "status" => "fail",
                                
                   ));
        }
    }
 }
}
        return response(array(
                                "Message" => "This user does not exist",
                                "code" => 200,
                                "status" => "fail",
                                
         ));
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
    public function store(Request $request)
    {
        //
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
