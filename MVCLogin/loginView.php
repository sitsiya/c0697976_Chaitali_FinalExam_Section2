<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($view['Success']) && $view['Success']!='' )
    echo $view['Success']." at loginView";
else
    echo $view['Error'];
