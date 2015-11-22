<?php

class tblDonator {
    var $table_name = '';
    var $table_fields = array('trans_id', 'team_id', 'payment_type', 'show_amount', 'donator_name', 'donator_email', 'amount', 'trans_detail');
    
    function __construct(){
        global $wpdb;
        $this->table_name = $wpdb->prefix.'cfs_donator';
    }
    
    function insert($data){
        global $wpdb;
        $insertData = array();
        foreach($data as $key => $value){
            if(in_array($key, $this->table_fields)){
                $insertData[$key] = $value;
            }
        }
        
        $insert_id = $wpdb->insert($this->table_name,$insertData);
        
        return $wpdb->insert_id;
    }
    
    function update($data){
        global $wpdb;
        $updateData = array();
        foreach($data as $key => $value){
            if(in_array($key, $this->table_fields)){
                $updateData[$key] = $value;
            }
        }
        $result = $wpdb->update($this->table_name,$updateData,array('id'=>$data['id']));
        if($result === false){
            return false;
        }else{
            return true;
        }
    }
    
    function delete($id){
        global $wpdb;
        return $wpdb->delete($this->table_name, array('id' =>  $id));
    }
}
