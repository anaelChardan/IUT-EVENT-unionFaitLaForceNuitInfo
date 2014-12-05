<?php
/**
 * Created by PhpStorm.
 * User: corentin
 * Date: 05/12/14
 * Time: 02:46
 */

namespace App\Controllers;

use App\Framework\Controller;
use App\Models\Request;

class RequestController extends Controller{
    public function getIndex(){
        $centers= $this->repo('CrisisCenter')->all();

        return $this->naturalView(["centers" =>$centers]);
    }


    public function getRequest() {
        $request = $this->needsEntity('Request','id');
        $products = $this->repo('Product')->all();
        return $this->naturalView(["request"=>$request,"products"=>$products]);
    }

    public function postIndex(){
        $request = new Request();

        $request->crisis_center_id = $this->request->crisis_center_id;
        $request->reception_date = $this->request->reception_date;
        $request->creation_date = date("Y-m-d H:i:s");
        $request->priority = $this->request->priority;

        $request->save();

        return $this->redirect('Request','request',['id'=>$request->id()]);
    }

    public function postRequest(){
        $query = "INSERT INTO brigademt_Product_Request (product_id,request_id) VALUES(:pid,:rid)";
        $this->app->db->success($query,['pid'=>$this->request->product_id,'rid'=>$this->request->id]);
        return $this->redirect('Request','request',['id'=>$this->request->id]);
    }

    public function getDelete(){
        $query = "DELETE FROM brigademt_Product_Request WHERE product_id=:id";
        $this->app->db->success($query,['id'=>$this->product_id]);
        return $this->redirect('Request','request',['id'=>$this->request->id]);
    }

    public function getDelete() {
        $pid =  $this->needs('product');
        $rid =  $this->needs('id');

        $query = "DELETE FROM brigademt_Product_Request WHERE product_id=:pid and request_id=:rid";
        if (!$this->app->db->success($query,['pid'=>$pid,'rid'=>$rid]))
            $this->app->raise(500, "Ok, je peux pas supprimer. Demande à PHILAE");

        return $this->redirect('Request','request',['id'=>$rid]);
    }

}