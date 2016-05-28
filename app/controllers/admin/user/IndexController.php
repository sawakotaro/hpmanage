<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace admin\user;

use \Illuminate\Support\Facades\View;

class IndexController extends \BaseController {
    
    
    public function getIndex() {
        
        return View::make('user.index');
    }
    
    
    
}
