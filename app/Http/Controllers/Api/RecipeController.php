<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function show(){
        $user = Auth::user();
        return new RecipeResource($user->recipe()->get());
    }

    protected function toPerK(float $BMI, string $professionType){
        switch($BMI)
        {
            case $BMI<18.5 :
                switch($professionType){
                    case "0" :
                        $perk = 25;
                        break;
                    case "1" :
                        $perk = 35;
                        break;
                    case "2" :
                        $perk = 40;
                        break; 
                    case "3" :
                        $perk = 50;
                        break;
                }
                break;
            case $BMI<23 :
                switch($professionType){
                    case "0" :
                        $perk = 20;
                        break;
                    case "1" :
                        $perk = 30;
                        break;
                    case "2" :
                        $perk = 35;
                        break; 
                    case "3" :
                        $perk = 40;
                        break;
                }
                break;
            case $BMI>=23 :
                switch($professionType){
                    case "0" :
                        $perk = 15;
                        break;
                    case "1" :
                        $perk = 25;
                        break;
                    case "2" :
                        $perk = 30;
                        break; 
                    case "3" :
                        $perk = 35;
                        break;
                }
                break;
        }
        return $perk;
    }

    // 产生饮食处方
    public function store()
    {
        $user = Auth::user();
        $information = $user->information();
        $weight = $information->value('weight');
        $height = $information->value('height');
        // 1. 计算BMI
        $BMI = $weight / pow($height/100,2);
        // 2. 获取运动量
        $profession = $information->value('profession');
        $professionType = DB::table("profession")->where('name', $profession)->value('type');
        // 3. 根据BMI和运动量获得每日每公斤体重所需热量
        $perk = $this->toPerK($BMI, $professionType);
        $calorie = $perk * $weight;
        // 4. 根据卡路里计算食物分量
        $exchangeNum = round($calorie/90);
        $carExchangeNum = round($exchangeNum * 0.6);
        $axunExchangeNum = round($exchangeNum * 0.25);
        $proExchangeNum = $exchangeNum - $carExchangeNum - $axunExchangeNum;
        // 5. 确认六大类食物的交换分数
        $vegetableNum = 1;
        $fruitNum = 1;
        $cerealNum = $carExchangeNum - $vegetableNum - $fruitNum;
        $beanProductNum = 2;
        $greaseNum = 2;
        $meatNum = $proExchangeNum - $beanProductNum + $axunExchangeNum - $greaseNum;
        // 6. 食物交换分数转化为克数与食物名称
        // rule1: 早餐只有 cereal beanProduct meat
        //        中餐有   cereal beanProduct meat vegetable fruit grease
        //        晚餐有   cereal meat vegetable fruit grease 
        $complicationList = explode(',', $information->value('complication'));
        $complications = DB::table('complication')->whereIn('name', $complicationList)->get();
        // 禁食列表
        $foods = [];
        foreach($complications as $complication){
            $foodsi = DB::table('food_complication')->whereIn('complication_id', [$complication->id])->get();
            foreach($foodsi as $foodi){
                array_push($foods, $foodi->food_id);
            }
        }
        $vegetables = DB::table("foods")->where('type', 'vegetable')->whereNotIn('id', $foods)->orderBy('gi')->take(2)->get(['name', 'g'])->toArray();
        $fruits = DB::table("foods")->where('type', 'fruit')->whereNotIn('id', $foods)->orderBy('gi')->take(2)->get(['name', 'g'])->toArray();
        $cereals = DB::table("foods")->where('type', 'cereal')->whereNotIn('id', $foods)->orderBy('gi')->take(3)->get(['name', 'g'])->toArray();
        $beanProducts = DB::table("foods")->where('type', 'beanProduct')->whereNotIn('id', $foods)->orderBy('gi')->take(2)->get(['name', 'g'])->toArray();
        $greases = DB::table("foods")->where('type', 'grease')->whereNotIn('id', $foods)->orderBy('gi')->take(2)->get(['name', 'g'])->toArray();
        $meats = DB::table("foods")->where('type', 'meat')->whereNotIn('id', $foods)->orderBy('gi')->take(3)->get(['name', 'g'])->toArray();
        // 7. 组合形成处方        
        $breakfastCereal = $cereals[0]->name . " " . round($cereals[0]->g * $cerealNum * 0.2) . "g";
        $lunchCereal = $cereals[1]->name . " " . round($cereals[1]->g * $cerealNum * 0.4) . "g";
        $dinnerCereal = $cereals[2]->name . " " . round($cereals[2]->g * $cerealNum * 0.4) . "g";
        $breakfastBeanProduct = $beanProducts[0]->name . " " . round($beanProducts[0]->g * $beanProductNum * 0.5) . "g";
        $lunchBeanProduct = $beanProducts[1]->name . " " . round($beanProducts[1]->g * $beanProductNum * 0.5) . "g";
        $breakfastMeat = $meats[0]->name . " " . round($meats[0]->g * $meatNum * 0.2) . "g";
        $lunchMeat = $meats[1]->name . " " . round($meats[1]->g * $meatNum * 0.4) . "g";
        $dinnerMeat = $meats[2]->name . " " . round($meats[2]->g * $meatNum * 0.4) . "g";
        $lunchVegetable = $vegetables[0]->name . " " . round($vegetables[0]->g * $vegetableNum * 0.5) . "g";
        $dinnerVegetable = $vegetables[1]->name . " " . round($vegetables[1]->g * $vegetableNum * 0.5) . "g";
        $lunchFruit = $fruits[0]->name . " " . round($fruits[0]->g * $fruitNum * 0.5) . "g";
        $dinnerFruit = $fruits[1]->name . " " . round($fruits[1]->g * $fruitNum * 0.5) . "g";
        $lunchGrease = $greases[0]->name . " " . round($greases[0]->g * $greaseNum * 0.5) . "g";
        $dinnerGrease = $greases[1]->name . " " . round($greases[1]->g * $greaseNum * 0.5) . "g";
        $breakfast = $breakfastCereal . ',' . $breakfastBeanProduct . ',' . $breakfastMeat;
        $lunch = $lunchCereal . ',' . $lunchBeanProduct . ',' . $lunchMeat . ',' . $lunchVegetable . ',' . $lunchFruit . ',' . $lunchGrease;
        $dinner = $dinnerCereal . ',' . $dinnerMeat . ',' . $dinnerVegetable . ',' . $dinnerFruit . ',' . $dinnerGrease ;        
        // 8. 数据库存储
        $recipe = new Recipe([
            'breakfast' => $breakfast,
            'lunch' => $lunch,
            'dinner' => $dinner,
            'other' => ''
        ]);
    
        $user->recipe()->delete();
        $user->recipe()->save($recipe);
        return new RecipeResource($recipe);
    }
}
