<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace \Controllers;
use Images as ImageModel;

/**
 * Description of ImagesController
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class ImagesController extends Controller{
    public function getIndex(){}
    public function getFull($hash) {
        
        /* @var $dbImage ImageModel */
        $dbImage = ImageModel::whereHash($hash)->first();
        if (!$dbImage) {
            abort(404);
        }
        
        $status = 200;
        try {
            $content = $dbImage->getFull();
            $headers = [
                'Content-Type'=> $dbImage->getMime()
            ];
        } catch (\Exception $ex) {
            dd ($ex);
            abort(404);
        }
        return response($content, $status, $headers);
    }
    
    public function getFit(\Controllers\Request $input, $hash) {
        
        /* @var $dbImage ImageModel */
        $dbImage = ImageModel::whereHash($hash)->first();
        if (!$dbImage) {
            abort(404);
        }
        
        $status = 200;
        try {
            $content = $dbImage->getFit($input->all());
            $headers = [
                'Content-Type'=> $dbImage->getMime()
            ];
        } catch (\Exception $ex) {
            dd ($ex);
            abort(404);
        }
        return response($content, $status, $headers);
    }
    
    public function getCropFit(\Controllers\Request $input, $hash) {
        
        /* @var $dbImage ImageModel */
        $dbImage = ImageModel::whereHash($hash)->first();
        if (!$dbImage) {
            abort(404);
        }
        
        $status = 200;
        try {
            $content = $dbImage->getCropFit($input->all());
            $headers = [
                'Content-Type'=> $dbImage->getMime()
            ];
        } catch (\Exception $ex) {
            dd ($ex);
            abort(404);
        }
        return response($content, $status, $headers);
    }
}
