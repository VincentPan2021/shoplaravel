<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop\Entity\Merchandise;
use App\Shop\Entity\Transaction;
use App\Shop\Entity\User;
use Image;
use Validator;
use Exception;
use DB;

class MerchandiseController extends Controller
{
    //merchandiseCreatProcess
    public function merchandiseCreatProcess(){
        $merchandise_data = [
            'status'            =>  'C',
            'name'              =>  '',
            'name_en'           =>  '',
            'introduction'      =>  '',
            'introduction_en'   =>  '',
            'photo'             =>  null,
            'price'             => 0,
            'remain_count'      => 0
        ];

        $merchandise = Merchandise::create($merchandise_data);

        return redirect('/merchandise/'. $merchandise->id .'/edit');
    }

    //merchandiseItemEditPage
    public function merchandiseItemEditPage($merchandise_id){
        $merchandise = Merchandise::findOrFail($merchandise_id);

        if(!is_null($merchandise->photo)){
            $merchandise->photo = url($merchandise->photo);
        }else{
            $merchandise->photo = '/images/noimage.jpg';
        }

        $binding = [
            'title' => '商品編輯',
            'Merchandise' => $merchandise
        ];

        return view('merchandise.editMerchandise', $binding);
    }

    //merchandiseItemUpdateProcess
    public function merchandiseItemUpdateProcess($merchandise_id){
        //取得商品資料
        $Merchandise = Merchandise::findOrFail($merchandise_id);

        $input = request()->all();

        //驗證規則
        $rules = [
            'status' => [
                'required', 'in:C,S'
            ],
            'name' => [
                'required', 'max:80'
            ],
            'name_en' => [
                'max:80'
            ],
            'introduction' => [
                'required', 'max:2000'
            ],
            'introduction_en' => [
                'max:2000'
            ],
            'photo' => [
                'file',
                'image',
                'max: 10240'    //10MB
            ],
            'price' => [
                'required', 'integer', 'min:0'
            ],
            'remain_count' => [
                'required', 'integer', 'min:0'
            ]
        ];

        //驗證資料
        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return redirect('/merchandise/'. $Merchandise->id .'/edit')
                    ->withErrors($validator)
                    ->withInput();
        }

        if(isset($input['photo'])){
            $photo = $input['photo'];

            $file_ext = $photo->getClientOriginalExtension();

            $file_name = uniqid() . "." . $file_ext;

            $relative_path = 'images/merchandise/' . $file_name;

            //'D:\shop_laravel\public' + '\images\merchandise'
            $file_path = public_path($relative_path);

            $image = Image::make($photo)->fit(450,300)->save($file_path);

            $input['photo'] = $relative_path;
        }

        $Merchandise->update($input);

        return redirect('/merchandise/'. $merchandise_id .'/edit');
    }

    //merchandiseManageListPage
    public function merchandiseManageListPage(){
        $row_per_page = 2;

        $Merchandises = Merchandise::OrderBy('created_at', 'desc')
                                    ->paginate($row_per_page);
        
        foreach($Merchandises as &$Merchandise){
            if(!is_null($Merchandise->photo)){
                $Merchandise->photo = url($Merchandise->photo);
            }
        }

        $binding = [
            'title' => '商品管理',
            'MerchandisePaginate' => $Merchandises
        ];
        
        return view('merchandise.manageMerchandise', $binding);
    }

    //merchandiseListPage
    public function merchandiseListPage(){
        $row_per_page = 2;

        $Merchandises = Merchandise::OrderBy('created_at', 'desc')
                                    ->where('status', 'S')      //限定可銷售資料
                                    ->paginate($row_per_page);
        
        foreach($Merchandises as &$Merchandise){
            if(!is_null($Merchandise->photo)){
                $Merchandise->photo = url($Merchandise->photo);
            }
        }

        $binding = [
            'title' => '商品清單',
            'MerchandisePaginate' => $Merchandises
        ];
        
        return view('merchandise.listMerchandise', $binding);
    }

    //merchandiseItemPage
    public function merchandiseItemPage($merchandise_id){
        $merchandise = Merchandise::where('id', $merchandise_id)->where('status', 'S')->first();

        if(!is_null($merchandise->photo)){
            $merchandise->photo = url($merchandise->photo);
        }else{
            $merchandise->photo = '/images/noimage.jpg';
        }

        $binding = [
            'title' => '商品檢視',
            'Merchandise' => $merchandise
        ];

        return view('merchandise.showMerchandise', $binding);
    }

    //merchandiseItemBuyProcess
    public function merchandiseItemBuyProcess($merchandise_id){
        $input = request()->all();

        $rules = [
            'buy_count' => ['required', 'integer', 'min:1'],
        ];

        //驗證資料
        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return redirect('/merchandise/'. $Merchandise->id)
                    ->withErrors($validator)
                    ->withInput();
        }

        try {
            $user_id = session()->get('user_id');
            $User = User::findOrFail($user_id);

            DB::beginTransaction();

            $Merchandise = Merchandise::findOrFail($merchandise_id);

            $buy_count = $input["buy_count"];

            $remain_count_after_buy = $Merchandise->remain_count - $buy_count;
            if($remain_count_after_buy < 0){
                throw new Exception('商品數量不足!');
            }

            $Merchandise->remain_count = $remain_count_after_buy;
            $Merchandise->save();

            $total_price = $buy_count * $Merchandise->price;

            $transaction_data = [
                'user_id' => $User->id,
                'merchandise_id' => $Merchandise->id,
                'price' => $Merchandise->price,
                'buy_count' => $buy_count,
                'total_price' => $total_price
            ];

            Transaction::create($transaction_data);

            DB::commit();

            $message = [
                'msg' => [
                    '購買成功!'
                ]
            ];

            return redirect()
                    ->to('/merchandise/' . $Merchandise->id)
                    ->withErrors($message);

        } catch(Exception $exception) {

            DB::rollback();

            $error_message = [
                'msg' => [
                    $exception->getMessage()
                ]
            ];

            return redirect()
                    ->back()
                    ->withErrors($error_message)
                    ->withInput();
        }

        exit;
    }
}
