<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\OrderDetail;
use App\Production;
use App\Material;
use App\Product;
use App\Order;
use App\Bom;
use App\BomMaterial;
use App\MachineBreakdowns;
use App\SubMachines;
use App\WipProduction;
use App\ShiftLog;
use App\Human;
use App\ShiftLogDetails;
use App\Machines;
use App\StockLog;
use App\Scraps;

use Log;

class ProductionController extends Controller
{
    public function index()
    {
    	$orders = Order::where('deliver', 0)->where('submit', 1)->paginate(10);
        $products = Product::pluck('quantity','id');
        $flag;
        foreach ($products as $key => $value) {
            $flag[$key] = 0;
        }

        $boms =  Bom::all();
        $manfacturing_shifts = ShiftLog::where('manfacturing',1)->orderBy('shift_date','DESC')->get();
        $packaging_shifts = ShiftLog::where('manfacturing',0)->orderBy('shift_date','DESC')->get();

    	return view('bowner.production.index', compact('orders', 'products','boms','manfacturing_shifts','packaging_shifts'));
    }

    public function show($id)
    {
    	$order = Order::findOrFail($id);

    	return view('bowner.production.print', compact('order'));
    }

    public function complete($detail_qty, $id, $p_qty)
    {
        $product = Product::findOrFail($id);
        $material = Material::findOrFail($product->material_id);
        $o_qty = $detail_qty;
        $cur_prod_qty = $product->quantity;
        $p_extra = $product->extra;
        $m_qty = $material->quantity;
        $p_unit_equi = $product->unit->equi;
        $m_unit_equi = $material->unit->equi;

        // update product and material quantity
        if ($p_qty < 0) { $p_qty = 0; }
        $required_p_qty = $o_qty - $p_qty;
        $required_m_qty = intval(ceil(($required_p_qty * $p_unit_equi) / $m_unit_equi ));
        $extra_qty = $p_extra + $required_m_qty * $m_unit_equi - $required_p_qty * $p_unit_equi;
        
        // Include extra calculation
        $check_extra = $required_p_qty * $p_unit_equi % $m_unit_equi;

        // Check if extra is enough for 1 product qty
        if (($check_extra != 0) && ($check_extra <= $p_extra)) {
            $required_m_qty = $required_m_qty - 1;
            $extra_qty = $p_extra - $check_extra; 
        }

        $product->quantity = $cur_prod_qty + $required_p_qty;
        $product->extra = $extra_qty;

        if ($extra_qty > $p_unit_equi) {
            $product->quantity += intval(floor($extra_qty / $p_unit_equi));
            $product->extra = $extra_qty % $p_unit_equi;
        }

        $material->quantity = $m_qty - $required_m_qty; // remain material qty

        $product->save(); 
        $material->save();

        Session::flash('updated_message', 'The production has been updated');

        return redirect()->back();
    }

    public function BOM(){

        $materials = Material::pluck('name', 'id')->all();
        $products =  Product::where('make',true)->get();


        
        return view('bowner.production.bomCreate', compact( 'products', 'materials'));
    }

    public function BOMDetails($id){
        $bom = Bom::findOrFail($id);
        $materials = BomMaterial::where('bom_id',$id)->get();
        return view('bowner.production.bomDetails', compact('bom','materials'));

    }

    public function SaveBOM(Request $request){


        $bom = new Bom();

        $bom->name = $request['name'];
        $bom->product_id = $request['product'];
        $bom->note = $request['note'];
        $bom->save();


        $i = 0;
        $materials = array_filter($request->materials);
        foreach ($materials as $material) {

            $BomMaterial = new BomMaterial;
            $BomMaterial->bom_id = $bom->id;
            $BomMaterial->material_id = $material;
            $BomMaterial->quantity = $request->quantity[$i];
            $BomMaterial->save();

            $i++;
        }

        Session::flash('updated_message', 'BOM has been submitted');

         return redirect('bowner/production');
        
    }

    public function showReports(){

       // $breakdowns = MachineBreakdowns::pluck('name', 'id')->all();
       // $machine_parts = SubMachines::all();
       // $leaders = Human::where('job','مشرف وردية')->get();
       // $wips = WipProduction::where('quantity','>',0)->where('packaging',0)->get();

        //$last_3_pck = ShiftLog::where('manfacturing',0)->orderBy('shift_date','DESC')->take(5)->get();
        //$last_3_mnf = ShiftLog::where('manfacturing',1)->orderBy('shift_date','DESC')->take(5)->get();
        //, compact('last_3_mnf','last_3_pck')
        return view('bowner.production.shiftReport');
    }

    public function showShiftReportManfacturing(){

        $machine_parts = SubMachines::all();
        $leaders = Human::where('job','مشرف وردية')->get();
        $wips = WipProduction::where('quantity','>',0)->where('packaging',0)->get();

        return view('bowner.production.manfacturingShiftReport', compact('leaders' , 'machine_parts','wips'));
    }

    public function showShiftReportPackaging(){

        $array = array();
        $leaders = Human::where('job','مشرف وردية')->get();
        $wips = WipProduction::where('quantity','>',0)->where('packaging',0)->get();
        
        foreach ($wips as $key => $value) {
             Log::info(intval($value->packaged) + intval($value->scraps));
             Log::info(intval($value->quantity));
            if( (intval($value->quantity)  <= intval($value->packaged) + intval($value->scraps)) ){
                array_push($array, $value);
            }

        }


        return view('bowner.production.packagingShiftReport', compact('leaders','array'));
    }

    public function showShiftReport(){

       
    }

    public function storeShiftReportPackaging(Request $request){

        //Log::info($request);


        // loop throught the shift 

        foreach ($request->shift as $key => $value) {

          //  Log::info($key);

            // now save the shift info 
       // if($request->quantity[$key] > 0){}

            $shift_log = new ShiftLog();
            $shift_log->manfacturing = 0;
            $shift_log->workers = $request->operators[$key];
            $shift_log->human_id = $request->shift_leader;
            $shift_log->shift_type = $request->shift_type;
            $shift_log->shift_date = date("Y-m-d", strtotime($request->shift_date));
            $shift_log->operation_duration = $request->duration[$key];
            $shift_log->scrap = $request->scrap[$key];
            $shift_log->notes = $request->notes[$key];
            $shift_log->machine_id = $request->product[$key];
            $shift_log->save();



            // move products to inventory with batch id 

            $wip = new WipProduction();
            $wip->product_id = $request->product[$key];
            $wip->quantity = $request->quantity[$key];
            $wip->shift_id = $shift_log->id;
            $wip->packaging = 1;
            //if($wip->quantity > 0)
            $wip->save();


            $scrap = new Scraps();
            $scrap->shift_id = $value;
            $scrap->product_id = $request->product[$key];
            $scrap->packaging_id = $shift_log->id;
            $scrap->amount = $request->scrap[$key];
            $scrap->save();


            
            $wip = WipProduction::where('shift_id',$value)->first();
            if($wip->quantity > 0)
                $packaged = $request->quantity[$key] / $wip->product->unit->equi ; 
            else
                $packaged = 0;
        

            if($request->done &&$request->done[$key])
                $wip->quantity = 0;
            else
                if($wip->quantity > 0)
                    $wip->packaged = $wip->packaged + $request->quantity[$key];

            if($request->scrap[$key] > 0){
                $wip->scraps = $wip->scraps + $request->scrap[$key];
            }    


            $wip->save();

            $product = $wip->product;
            $product->quantity = $product->quantity + $packaged;
            $product->save();

            // calculate the effeciency for this entry 




            // save the log to the stock log 
            if($packaged > 0){
                $stock = new StockLog();
                $stock->product_id = $product->id;
                $stock->type = 'Receive - Manfacturing';
                $stock->quantity = $packaged;
                $stock->warehouse_id = 0;
                $stock->notes = $request->batch[$key];
                $stock->save();
            }
            

        }

         return redirect('/production/shift_report/show');

    }

    public function storeShiftReport(Request $request){

       
        // we will save the report into a table containing the machine / shift log 
  

       // Log::info($request);


        // ear loop 
         $product = Product::where('name','like','%Earloop Face Mask%')->where('color',$request->product_color_machine_1_ear_loop)->where('type',$request->product_type_machine_1_ear_loop)->first();

        $wip = new WipProduction();
        $wip->product_id = $product->id;
        $wip->quantity = $request->quantity_machine_1_ear_loop;
        $wip->machine_id = 5;
        $wip->packaging = 0;
        if($wip->quantity > 0)
          $wip->save();

        $machine = Machines::findOrFail($wip->machine_id);
        $shift_log = new ShiftLog();
        $shift_log->manfacturing = 1;
        $shift_log->workers = $request->operators_machine_1_ear_loop;
        $shift_log->machine_id = $wip->machine_id;
        $shift_log->human_id = $request->shift_leader;
        $shift_log->shift_type = $request->shift_type;
        $shift_log->shift_date = date("Y-m-d", strtotime($request->shift_date));
        $shift_log->operation_duration = $request->operation_duration_machine_1_ear_loop;
        $shift_log->notes = $request->other_notesـbreakdowns_machine_ear_loop_1;
        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();

        $duration_sum = 0;
        foreach ($request->duration_machine_ear_loop_1 as $key => $value) {
            if($value){
                $shift_log_details = new ShiftLogDetails();
                $shift_log_details->log_id = $shift_log->id;
                $shift_log_details->duration = $value;
                $shift_log_details->breakdown = $request->notes_machine_ear_loop_1[$key];
                $shift_log_details->save();

                $duration_sum = $duration_sum + $value;

            }
        }

        $shift_log->total_breakdown_duration = $duration_sum ;
        $shift_log->production_effeciency = ( ( ($request->quantity_machine_1_ear_loop / $request->operation_duration_machine_1_ear_loop) / 60 ) / $machine->production_per_min ) * 100;

        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();



        // tie on 
        $product = Product::where('name','like','%Tie On Face Mask%')->where('color',$request->product_color_machine_1_tie_on)->where('type',$request->product_type_machine_1_tie_on)->first();

        $wip = new WipProduction();
        $wip->product_id = $product->id;
        $wip->quantity = $request->quantity_machine_1_tie_on;
        $wip->machine_id = 6;
        $wip->packaging = 0;
        if($wip->quantity > 0)
          $wip->save();
       
        $machine = Machines::findOrFail($wip->machine_id);
        $shift_log = new ShiftLog();
        $shift_log->manfacturing = 1;
        $shift_log->workers = $request->operators_machine_1_tie_on;
        $shift_log->machine_id = $wip->machine_id;
        $shift_log->human_id = $request->shift_leader;
        $shift_log->shift_type = $request->shift_type;
        $shift_log->shift_date = date("Y-m-d", strtotime($request->shift_date));
        $shift_log->operation_duration = $request->operation_duration_machine_1_tie_on;
        $shift_log->notes = $request->other_notesـbreakdowns_machine_tie_on_1;
        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();

        $duration_sum = 0;
        foreach ($request->duration_machine_tie_on_1 as $key => $value) {
            if($value){
                $shift_log_details = new ShiftLogDetails();
                $shift_log_details->log_id = $shift_log->id;
                $shift_log_details->duration = $value;
                $shift_log_details->breakdown = $request->notes_machine_tie_on_1[$key];
                $shift_log_details->save();

                $duration_sum = $duration_sum + $value;

            }
        }

        $shift_log->total_breakdown_duration = $duration_sum ;
        $shift_log->production_effeciency = ( ( ($request->quantity_machine_1_tie_on / $request->operation_duration_machine_1_tie_on) / 60 ) / $machine->production_per_min ) * 100;

        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();



        // main machine 

        $machine = Machines::findOrFail(1);
        $shift_log = new ShiftLog();
        $shift_log->manfacturing = 1;
        $shift_log->workers = 1;
        $shift_log->machine_id = 1;
        $shift_log->human_id = $request->shift_leader;
        $shift_log->shift_type = $request->shift_type;
        $shift_log->shift_date = date("Y-m-d", strtotime($request->shift_date));
        $shift_log->operation_duration = ($request->operation_duration_machine_1_tie_on + $request->operation_duration_machine_1_ear_loop) / 2;
        $shift_log->notes = $request->other_notesـbreakdowns_machine_1;
        $shift_log->save();

       // $wip->shift_id = $shift_log->id;
       // if($wip->quantity > 0)
       //   $wip->save();

        $duration_sum = 0;
        foreach ($request->duration_machine_1 as $key => $value) {
            if($value){
                $shift_log_details = new ShiftLogDetails();
                $shift_log_details->log_id = $shift_log->id;
                $shift_log_details->duration = $value;
                $shift_log_details->breakdown = $request->notes_machine_1[$key];
                $shift_log_details->save();

                $duration_sum = $duration_sum + $value;

            }
        }

        $shift_log->total_breakdown_duration = $duration_sum ;

         
            $shift_log->production_effeciency =( ( ( ( (

                $request->quantity_machine_1_ear_loop / $request->operation_duration_machine_1_ear_loop) / 60 ) / ($machine->production_per_min/2) ) * 100 ) 

                 + ( ( ( ($request->quantity_machine_1_tie_on / 

                    $request->operation_duration_machine_1_tie_on) / 60
                     ) / ($machine->production_per_min/2) ) * 100 ) ) / 2;

        $shift_log->save();

        // $wip->shift_id = $shift_log->id;
        //if($wip->quantity > 0)
        //  $wip->save();



        // overshoes 


        $product = Product::where('name','like','%Over Shoes%')->where('color',$request->product_color_machine_over_shoes)->where('type',$request->product_type_machine_over_shoes)->first();

        $wip = new WipProduction();
        $wip->product_id = $product->id;
        $wip->quantity = $request->quantity_machine_over_shoes;
        $wip->machine_id = 2;
        $wip->packaging = 0;
        if($wip->quantity > 0)
          $wip->save();


        $machine = Machines::findOrFail($wip->machine_id);
        $shift_log = new ShiftLog();
        $shift_log->manfacturing = 1;
        $shift_log->workers = $request->operators_machine_over_shoes;
        $shift_log->machine_id = $wip->machine_id;
        $shift_log->human_id = $request->shift_leader;
        $shift_log->shift_type = $request->shift_type;
        $shift_log->shift_date = date("Y-m-d", strtotime($request->shift_date));
        $shift_log->operation_duration = $request->operation_duration_machine_over_shoes;
        $shift_log->notes = $request->other_notesـbreakdowns_machine_over_shoes;
        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();

        $duration_sum = 0;
        foreach ($request->breakdown_duration_machine_over_shoes as $key => $value) {
            if($value){
                $shift_log_details = new ShiftLogDetails();
                $shift_log_details->log_id = $shift_log->id;
                $shift_log_details->duration = $value;
                $shift_log_details->breakdown = $request->breakdown_notes_machine_over_shoes[$key];
                $shift_log_details->save();

                $duration_sum = $duration_sum + $value;

            }
        }

        $shift_log->total_breakdown_duration = $duration_sum ;
        if($request->quantity_machine_over_shoes  > 0)
            $shift_log->production_effeciency = ( ( ($request->quantity_machine_over_shoes / $request->operation_duration_machine_over_shoes) / 60 ) / $machine->production_per_min ) * 100;
        else
             $shift_log->production_effeciency = 0;

        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();



        // overhead 

        $product = Product::where('name','like','%Over Head%')->where('color',$request->product_color_machine_over_head)->where('type',$request->product_type_machine_over_head)->first();

        $wip = new WipProduction();
        $wip->product_id = $product->id;
        $wip->quantity = $request->quantity_machine_over_head;
        $wip->machine_id = 3;
        $wip->packaging = 0;
        if($wip->quantity > 0)
          $wip->save();


        $machine = Machines::findOrFail($wip->machine_id);
        $shift_log = new ShiftLog();
        $shift_log->manfacturing = 1;
        $shift_log->workers = $request->operators_machine_over_head;
        $shift_log->machine_id = $wip->machine_id;
        $shift_log->human_id = $request->shift_leader;
        $shift_log->shift_type = $request->shift_type;
        $shift_log->shift_date = date("Y-m-d", strtotime($request->shift_date));
        $shift_log->operation_duration = $request->operation_duration_machine_over_head;
        $shift_log->notes = $request->other_notesـbreakdowns_machine_over_head;
        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();

        $duration_sum = 0;
        foreach ($request->breakdown_duration_machine_over_head as $key => $value) {
            if($value){
                $shift_log_details = new ShiftLogDetails();
                $shift_log_details->log_id = $shift_log->id;
                $shift_log_details->duration = $value;
                $shift_log_details->breakdown = $request->breakdown_notes_machine_over_head[$key];
                $shift_log_details->save();

                $duration_sum = $duration_sum + $value;

            }
        }

        $shift_log->total_breakdown_duration = $duration_sum ;

        if($request->quantity_machine_over_head  > 0)
            $shift_log->production_effeciency = ( ( ($request->quantity_machine_over_head / $request->operation_duration_machine_over_head) / 60 ) / $machine->production_per_min ) * 100;
        else 
            $shift_log->production_effeciency = 0;

        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();

        // bracelet 

        $product = Product::where('name','like','%ID Bracelet%')->where('color',$request->product_color_machine_bracelet)->where('type',$request->product_type_machine_bracelet)->first();

        $wip = new WipProduction();
        $wip->product_id = $product->id;
        $wip->quantity = $request->quantity_machine_bracelet;
        $wip->machine_id = 4;
        $wip->packaging = 0;
        if($wip->quantity > 0)
          $wip->save();        


        $machine = Machines::findOrFail($wip->machine_id);
        $shift_log = new ShiftLog();
        $shift_log->manfacturing = 1;
        $shift_log->workers = $request->operators_machine_bracelet;
        $shift_log->machine_id = $wip->machine_id;
        $shift_log->human_id = $request->shift_leader;
        $shift_log->shift_type = $request->shift_type;
        $shift_log->shift_date = date("Y-m-d", strtotime($request->shift_date));
        $shift_log->operation_duration = $request->operation_duration_machine_bracelet;
        $shift_log->notes = $request->other_notesـbreakdowns_machine_bracelet;
        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();

        $duration_sum = 0;
        foreach ($request->breakdown_duration_machine_bracelet as $key => $value) {
            if($value){
                $shift_log_details = new ShiftLogDetails();
                $shift_log_details->log_id = $shift_log->id;
                $shift_log_details->duration = $value;
                $shift_log_details->breakdown = $request->breakdown_notes_machine_bracelet[$key];
                $shift_log_details->save();

                $duration_sum = $duration_sum + $value;

            }
        }

        $shift_log->total_breakdown_duration = $duration_sum ;
        if($request->quantity_machine_bracelet  > 0)
            $shift_log->production_effeciency = ( ( ($request->quantity_machine_bracelet / $request->operation_duration_machine_bracelet) / 60 ) / $machine->production_per_min ) * 100;
        else
             $shift_log->production_effeciency = 0 ;

        $shift_log->save();

        $wip->shift_id = $shift_log->id;
        if($wip->quantity > 0)
          $wip->save();




        return redirect('/production/shift_report/show');

    }

    public function deleteShiftReportDetials($shift_id){


        // get shift type , date and the shift leader 

        $shift = ShiftLog::findOrFail($shift_id);
        $shifts = ShiftLog::where('shift_date',$shift->shift_date)->where('shift_type',$shift->shift_type)->where('human_id',$shift->human_id)->get();

        foreach ($shifts as $key => $value) {
            $wip = WipProduction::where('shift_id',$value->id)->delete();
            $shift_log_details = ShiftLogDetails::where('log_id',$value->id)->delete();
            $value->delete();


            // delete the bom 
            // delete 
        }
       


        return redirect()->back();
    }

    public function deleteShiftReportPckDetials($shift_id){

         $shift = ShiftLog::findOrFail($shift_id);
        $shifts = ShiftLog::where('shift_date',$shift->shift_date)->where('shift_type',$shift->shift_type)->where('human_id',$shift->human_id)->get();

        foreach ($shifts as $key => $value) {
            $wip = WipProduction::where('shift_id',$value->id)->delete();
            $shift_log_details = ShiftLogDetails::where('log_id',$value->id)->delete();
            $value->delete();

            // delete the packaged from the production 
            // delete the scrap 
        }

        return redirect()->back();

    }

    public function listLastEntriesManfacturing(){
        
        $manfacturing_shifts = ShiftLog::where('manfacturing',1)->orderBy('shift_date','DESC')->get();
        return view('bowner.production.editLastManfacturingShiftReport', compact('manfacturing_shifts'));

    }

    public function listLastEntriesPackaging(){

        $packaging_shifts = ShiftLog::where('manfacturing',0)->orderBy('shift_date','DESC')->get();
        return view('bowner.production.editLastPackagingShiftReport', compact('packaging_shifts'));
    }

    public static function returnCode($number){

                switch ($number) {
                    case 0:
                        return "0";
                        break;
                    case 1:
                        return "A";
                        break;
                    case 2:
                        return "B";
                        break;
                    case 3:
                        return "C";
                        break;
                    case 4:
                        return "D";
                        break;
                    case 5:
                        return "D";
                        break;
                    case 6:
                        return "E";
                        break;
                    case 7:
                        return "F";
                        break;
                    case 8:
                        return "G";
                        break;
                    case 9:
                        return  "H";
                        break;                          
                }

                
            }
}
