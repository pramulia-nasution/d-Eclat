<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Declat;
use App\Itemset;
use App\Support;
use Illuminate\Http\Request;

class DeclatController extends Controller
{
    private $tidList = array();
    private $max;
    private $count;
    private $minSupport;
    private $limit = 80;

    public function __construct()
    {
        $this->middleware('auth');
        $this->minSupport = Support::select('supp')->where('id',1)->pluck('supp');
        $this->minSupport = $this->minSupport[0];
        $this->max = Declat::max('iterasi');
        $this->count = DB::table('datasets')->count();
    }
    public function index(Request $request)
    {
        if ($request->ajax()){
            $declat= Declat::where('iterasi',1)->get();
            return DataTables::of($declat)->addIndexColumn()
            ->editColumn('tidList', function(Declat $itemset) {
                return Str::limit($itemset->tidList,$this->limit);
            })->make(true);
        }
        $cek = Declat::where('iterasi',1)->count() > 0 ? false:true;
        $total = DB::table('itemsets')->count();
        return view('item.DuaItemset',compact('total','cek'));
    }
    public function Itemset3(Request $request){
        if($request->ajax()){
            $declat= Declat::where('iterasi',2)->get();
            return DataTables::of($declat)->addIndexColumn()
            ->editColumn('tidList', function(Declat $itemset) {
                return Str::limit($itemset->tidList,$this->limit);
            })->make(true);
        }
        $cek = Declat::where('iterasi',2)->count() > 0 ? false:true;
        $total = DB::table('declats')->where('iterasi','1')->count();
        return view('item.TigaItemset',compact('total','cek'));
    }
    public function Itemset4(Request $request){
        if($request->ajax()){
            $declat= Declat::where('iterasi',3)->get();
            return DataTables::of($declat)->addIndexColumn()
            ->editColumn('tidList', function(Declat $itemset) {
                return Str::limit($itemset->tidList,$this->limit);
            })->make(true);
        }
        $cek = Declat::where('iterasi',3)->count() > 0 ? false:true;
        $total = DB::table('declats')->where('iterasi','2')->count();
        return view('item.EmpatItemset',compact('total','cek'));
    }
    public function Itemset5(Request $request){
        if($request->ajax()){
            $declat= Declat::where('iterasi',4)->get();
            return DataTables::of($declat)->addIndexColumn()
            ->editColumn('tidList', function(Declat $itemset) {
                return Str::limit($itemset->tidList,$this->limit);
            })->make(true);
        }
        $cek = Declat::where('iterasi',4)->count() > 0 ? false:true;
        $total = DB::table('declats')->where('iterasi','3')->count();
        return view('item.LimaItemset',compact('total','cek'));
    }
    public function Itemset6(Request $request){
        if($request->ajax()){
            $declat= Declat::where('iterasi',5)->get();
            return DataTables::of($declat)->addIndexColumn()
            ->editColumn('tidList', function(Declat $itemset) {
                return Str::limit($itemset->tidList,$this->limit);
            })->make(true);
        }
        $cek = Declat::where('iterasi',5)->count() > 0 ? false:true;
        $total = DB::table('declats')->where('iterasi','4')->count();
        return view('item.EnamItemset',compact('total','cek'));
    }
    public function confidence(Request $request){
        if($request->ajax()){
            $nfdc = DB::table('confidences')->get();
            return DataTables::of($nfdc)->addIndexColumn()->make(true);
        }
        return response()->json(['success'=>'Sukses']);
    }

    public function evaluation(Request $request){
        if ($request->ajax()){
            $eva = DB::table('evaluation')->get();
            return DataTables::of($eva)->addIndexColumn()->make(true);
        }
        return response()->json(['success'=>'Sukses']);
    }

    public function clearData(){
        Declat::truncate();
        Itemset::truncate();
        DB::table('evaluation')->truncate();
        DB::table('confidences')->truncate();
        return response()->json(['success'=>'Data dikosongkan']);
    }


//---------------------------------------Get Query TidList------------------------------------------------
    public function makeItemset3(){
        $query = DB::table('itemsets')->pluck('inisial');
        $this->_makeItemset($query);
    }
    public function makeItemset4(){
        $query = DB::table('declats')->where('iterasi',1)->pluck('inisial');
        $this->_makeItemset($query);
    }
    public function makeItemset5(){
        $query = DB::table('declats')->where('iterasi',2)->pluck('inisial');
        $this->_makeItemset($query);
    }
    public function makeItemset6(){
        $query = DB::table('declats')->where('iterasi',3)->pluck('inisial');
        $results = $this->_makeItemset($query);
      //  $this->_makeConfidence($results);
    }



//-----------------------------------------Make Algorithm--------------------------------------------------
    private function _makeItemset($qry){
        $retur =[];
        for($i=0;$i<count($qry);$i++){
            $data = Declat::where('inisial','LIKE',$qry[$i].'%');
            if($this->max >= 2){
                $data->where('iterasi','>=',$this->max);
            }
            $val = $data->get();
            foreach($val as $n => $r){
                for($a=$n+1;$a<$data->count();$a++){
                    if($val[$n]['helper'] != $val[$a]['helper']){
                        $inisial = $this->_link($val[$a]['inisial']);
                        $list = $r->inisial.','.end($inisial);                       
                        $diff = array_diff($this->_link($val[$a]['tidList']),$this->_link($r->tidList));
                        $cek = $this->_link($val[$a]['tidList']);
                        $nilai = count($diff);
                        if (end($cek) == ""){
                            $nilai = 0;
                        }
                        $suppCount = $r->supportCount - $nilai;
                        $support = $suppCount/$this->count;
                        $link = $this->_link($val[$a]['helper']);
                        $helper = $val[$n]['helper'].','.end($link);
                        if($support >= $this->minSupport){
                            $res = ['iterasi'=>$this->max+1,'inisial'=>$list,'tidList'=>implode(',',$diff),'supportCount'=>$suppCount,'support'=>$support,'helper'=>$helper];
                            $ret = ['SuppAB'=>$suppCount,'SuppA'=>$r->supportCount,'Supp'=>$support,'list'=>$list];
                            array_push($this->tidList,$res);
                            array_push($retur,$ret);
                        }
                    }
                }
            }
        }DB::table('declats')->insert($this->tidList);
        return $retur;
    }

    private function _makeConfidence($val){
        $item = array();
        $evaluation = array();
        for($a=0;$a<count($val);$a++ ){
            $confidence = $val[$a]['SuppAB'] * 100 / $val[$a]['SuppA'];
            $link = $this->_link($val[$a]['list']);
            $input = array();
            for($b=0;$b<count($link);$b++){
                $set = Itemset::select('item')->where('inisial',$link[$b])->first();
                array_push($input,$set['item']);
            }
            $str =  $input[0].', '.$input[1].', '.$input[2].', '.$input[3].', '.$input[4].' => '.$input[5];
            $string = 'Jika seorang '.$input[0].' '.$input[1].' dengan pendidikan terakhir '.$input[2].' dan pekerjaan '.$input[3].
            ' serta memakai NAPZA '.$input[4].' maka tingkat kecanduan '.$input[5].' dengan Support '.round($val[$a]['Supp'],2).' % serta Confidence '.round($confidence,2).' %' ;
            $insert = ['itemset'=>$str,'support'=>round($val[$a]['Supp'],2),'confidence'=>round($confidence,2)];
            array_push($item,$insert); 
            array_push($evaluation,['name'=>$string]); 
        }
        DB::table('evaluation')->insert($evaluation);
        DB::table('confidences')->insert($item);
    }
    private function _link($item){
        return explode(',',$item);
    }
}
