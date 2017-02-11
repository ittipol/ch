<?php

namespace App\Http\Middleware;

use App\Models\Shop;
use App\Models\Slug;
use App\Models\PersonToShop;
use App\library\message;
use App\library\url;
use Closure;

class CheckForPersonHasShopPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(empty($request->slug)) {
        return redirect('home');
      }

      $url = new Url;
      
      $id = Slug::where('slug','like',$request->slug)->select('model_id')->first()->model_id;
      $shop = Shop::find($id);

      if(!$shop->checkPersonHasShopPermission()) {
        Message::display('ไม่อนุญาตให้แก้ไชร้านค้านี้ได้','error');
        return redirect('item/post');
      }

      // $personToShop = new PersonToShop;
      // $person = $personToShop->getData(array(
      //   'conditions' => array(
      //     ['person_id','=',session()->get('Person.id')],
      //     ['shop_id','=',$id],
      //   ),
      //   'fields' => array('role_id'),
      //   'first' => true
      // ));

      if($request->session()->has('Shop.'.$id.'.id')) {

        $personToShop = new PersonToShop;
        $person = $personToShop->getData(array(
          'conditions' => array(
            ['person_id','=',session()->get('Person.id')],
            ['shop_id','=',$id],
          ),
          'fields' => array('role_id'),
          'first' => true
        ));
        
        $request->session()->put('Shop.'.$id.'.id',$id);
        $request->session()->put('Shop.'.$id.'.model',$shop);
        $request->session()->put('Shop.'.$id.'.role_name',$person->role->name);
        $request->session()->put('Shop.'.$id.'.role_permission',$person->role->getPermission());
      }

      // get permission
      $request->attributes->add([
        'shopId' => $id,
        'shop' => $shop,
        'shopUrl' => $url->url('shop/'.$request->slug),
        'role' => $person->role->name,
        'permission' => $person->role->getPermission()
      ]);


      return $next($request);
    }
}
