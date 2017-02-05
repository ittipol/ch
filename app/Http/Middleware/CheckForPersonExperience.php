<?php

namespace App\Http\Middleware;

use App\Models\PersonExperience;
use Closure;

class CheckForPersonExperience
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
    $personExperience = new PersonExperience;
    if(!$personExperience->checkExistByPersonId()) {
      return redirect('experience');
    }

    return $next($request);
  }
}
