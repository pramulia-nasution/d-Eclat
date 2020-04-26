<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use App\Dataset;
use App\Itemset;
use App\Support;

class ItemController extends Controller
{
    private $data = array();
    private $tidList = array();
    private $item;
    private $count;
    private $minSupport; 
    
    public function __construct(){
        $this->middleware('auth');
        $this->minSupport = Support::select('supp')->where('id',1)->pluck('supp');
        $this->minSupport = $this->minSupport[0];
        $this->item = DB::table('itemsets');
        $this->count = DB::table('datasets')->count();
    }
    public function index(Request $request){
        if ($request->ajax()){
            $itemset = Itemset::all();
            return DataTables::of($itemset)->addIndexColumn()
            ->editColumn('tidList', function(Itemset $itemset) {
                return Str::limit($itemset->tidList,80);
            })->make(true);
        }
        return view('item.itemset',['count'=>$this->count,'countset'=>$this->item->count()]);
    }
    public function makeItemset(){
        $this->item->truncate();
        $key   = ['gender','usia','pendidikan','pekerjaan','tes','pemakaian'];
        $value = ['A','B','C','D','E','F','G'];
        //L,P
        for($a=0;$a<count($key);$a++){
            $item = DB::table('datasets')->select($key[$a])->distinct($key[$a])->get();
            $this->_setItem($item,$key[$a],$value[$a]);
        }
        $this->item->insert($this->data);
        $this->_makeTidList();
        return response()->json(['status'=>true]); 
    }

    private function _setItem($row,$col,$i){
        foreach($row as $k =>$val){
            //data [']
            array_push($this->data,array('item'=>$val->$col,'attribut'=>$col,'inisial'=>$i.$k));
        }
    }
//Inisialisasi TidList Awal
    //$row = L,P
    //$col = gender
    //$i = A
    private function _makeTidList(){
        foreach($this->item->select('id','attribut','item')->get() as $r){
            $dataset = Dataset::select('id')->whereNotIn($r->attribut,[$r->item])->pluck('id');
            $val = $this->count -  count($dataset);
            $list = preg_replace('/[^0-9\,]/','',$dataset);
            array_push($this->tidList,array(
                'id'=>$r->id,
                'tidList'=>$list, 
                'supportCount'=>$val, 
                'support'=>$val/$this->count
            ));
        }
        batch()->update(new Itemset,$this->tidList,'id');
    }
//Buat 2 Itemsets
    public function createSimpul(){
        $data = Itemset::select('inisial','attribut','tidList','supportCount')->where('support','>=',$this->minSupport);
        $isi = $data->get();
        //manggil data pertama
        foreach($isi as $a=>$b){
            //manggil data setelahnya
            for($c=$a+1;$c<$data->count();$c++){
                if($isi[$a]['attribut'] != $isi[$c]['attribut']){
                    $inisial = $isi[$a]['inisial'].','.$isi[$c]['inisial'];
                    $list = $isi[$a]['attribut'].','.$isi[$c]['attribut'];
                    $diff = array_diff(explode(',',$isi[$c]['tidList']),explode(',',$b->tidList));
                    $supCount = $b->supportCount - count($diff);
                    $support = $supCount/$this->count;
                    //gender.usia.pendidikan
                    if($support >= $this->minSupport){
                        $res =  ['iterasi'=>1,'inisial'=>$inisial,'tidList'=>implode(',',$diff),'supportCount'=>$supCount,'support'=>$support,'helper'=>$list];
                        array_push($this->tidList,$res);
                    }
                }
            }
        }
        DB::table('declats')->insert($this->tidList);
    }
} 
