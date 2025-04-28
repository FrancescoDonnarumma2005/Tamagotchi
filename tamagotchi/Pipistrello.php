<?php 
 class Pipistrello extends Animaletto{


   public $fame_decreaser=3;
   public $divertimento_decreaser=2;
   public $energia_decreaser=1;
   public $tipo="pipistrello";
   public $imgBackground="./src/sfondo_pipistrello.png";
   


    public function mangia(){
      if($this->fame<100){
        $this->fame+=20;
      }
      $this->fame=$this->check($this->fame);
    }
     public function accarezza(){
      if($this->divertimento<100){
        $this->divertimento+=10;
      }
      $this->divertimento=$this->check($this->divertimento);
    }
     
     public function dormi(){
      if($this->energia<100){
        $this->energia+=15;
      }
      $this->energia=$this->check($this->energia);
     }
     public function vita(){
      
        $this->vita-=15;
     }

     



}



?>