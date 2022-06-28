<?php
include_once('connection.php'); 
class Db_Class{
    private $table_name = 'collecte_globale_dk';

    // function createUser(){
    //     $sql = "INSERT INTO PUBLIC.".$this->table_name."(name,email,mobile_no,address) "."VALUES('".$this->cleanData($_POST['name'])."','".$this->cleanData($_POST['email'])."','".$this->cleanData($_POST['mobileno'])."','".$this->cleanData($_POST['address'])."')";
    //     return pg_affected_rows(pg_query($sql));
    // }

    // recuperer toutes les donnees en fonction de la base
    function getCircuit(){             
        $sql ="select *from public." .$this->cleanData($_POST['circuit']). "  where coordinati='".$this->cleanData($_POST['select'])."'";
        return pg_query($sql);
    }

    // recuperer les coordonnées geographiques
    function getGeom(){    
        $sql = "select *, (ST_AsGeoJSON(geom)) as geometry from public." .$this->cleanData($_POST['circuit']). "  where coordinati='".$this->cleanData($_POST['select'])."'";
        return pg_query($sql);
    }

    // recuperer toutes les donnees
    function getAllCirBal(){             
        $sql ="select *from public." . $this->table_name . "  ORDER BY id DESC";
        return pg_query($sql);
    } 

    // recuperer par coordination
    function findByCoordination(){             
        $sql ="select * from public." . $this->table_name . "  where coordinati='".$this->cleanData($_POST['select'])."'";
        return pg_query($sql);
    } 

    // recuperer les coords
    function findCoord(){             
        $sql ="select distinct coordinati from public." . $this->table_name;
        return pg_query($sql);
    } 
    // function getUserById(){    
  
    //     $sql ="select *from public." . $this->table_name . "  where id='".$this->cleanData($_POST['id'])."'";
    //     return pg_query($sql);
    // } 

    // function deleteuser(){    
  
    //      $sql ="delete from public." . $this->table_name . "  where id='".$this->cleanData($_POST['id'])."'";
    //     return pg_query($sql);
    // } 

    // function updateUser($data=array()){       
     
    //     $sql = "update public.user set name='".$this->cleanData($_POST['name'])."',email='".$this->cleanData($_POST['email'])."', mobile_no='".$this->cleanData($_POST['mobileno'])."',address='".$this->cleanData($_POST['address'])."' where id = '".$this->cleanData($_POST['id'])."' ";
    //     return pg_affected_rows(pg_query($sql));        
    // }
    function cleanData($val){
         return pg_escape_string($val);
    }
}
?>