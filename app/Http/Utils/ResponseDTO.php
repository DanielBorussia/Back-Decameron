<?php

namespace App\Http\Utils;

class ResponseDTO {

    private $status;
    private  $message;
    private  $data;
    private  $option;
    private  $resData = 
    [
        "status" => 0,
        "message" => "",
        "data" => [],
    ];
    
    public function response($response, $data = null) {
        $this->setStatus($response['status']);
        $this->setMessage($response['message']);
        $this->setData($data);
        return $this->getData();
    }

    public function getStatus() {
        return $status;
    }

    public function getMessage() {
        return $message;
    }

    public function getData() {
        $this->resData["status"] = $this->status;
        $this->resData["message"] = $this->message;
        $this->resData["data"] = $this->data;
        return $this->resData;
    }

    public function setData($data) {
        $this->data = $data;
    }
    public function setStatus($status) {
        $this->status = $status;
    }
    public function setMessage($message) {
        $this->message = $message;
    }


}



?>