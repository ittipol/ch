<?php

namespace App\Http\Middleware;

use App\Models\Shop;
use App\Models\Slug;
use App\Models\PersonToShop;
use App\library\message;
use Closure;
use Route;

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
      $name = Route::currentRouteName();

      $pages = array(
        'shop.manage' => true,
      );

      if(empty($name) || empty($pages[$name])) {
        Message::display('ไม่อนุญาตให้เข้าถึงหน้านี้ได้','error');
        return redirect('/');
      }

      $id = Slug::where('slug','like',$request->shopSlug)->select('model_id')->first()->model_id;
      // $shop = Shop::find($id);

      // if(!$shop->checkPersonHasShopPermission()) {
      //   Message::display('ไม่อนุญาตให้แก้ไขร้านค้านี้ได้','error');
      //   return redirect('/');
      // }

      $personToShop = new PersonToShop;
      $person = $personToShop->getData(array(
        'conditions' => array(
          ['person_id','=',session()->get('Person.id')],
          ['shop_id','=',$id],
        ),
        'fields' => array('role_id'),
        'first' => true
      ));

      if(empty($person)) {
        Message::display('ไม่อนุญาตให้แก้ไขร้านค้านี้ได้','error');
        return redirect('/');
      }

      $permission = $person->role->getPermission();

      if(is_array($pages[$name])) {
        dd('xxx');
      }

      // get permission
      // $request->attributes->add([
      //   'role' => $person->role->name,
      //   'permission' => $person->role->getPermission()
      // ]);

      // page level
      // who can access in this page?
      // admin = 1, can access all page
      // if(level <= pageLevel)

      return $next($request);
    }
}
