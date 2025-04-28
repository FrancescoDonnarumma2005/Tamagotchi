<?php
abstract class Animaletto {
    public $nomeAnimaletto;
    public $fame;
    public $divertimento;
    public $energia;
    public $vita;
    public $fame_decreaser;
    public $divertimento_decreaser;
    public $energia_decreaser;
    public $lastUpdate;
    public $tipo;
    public $imgBackground;

    public function addFame($fame){
        $this->fame+=$fame;
        $this->fame=$this->check($this->fame);
    }
    public function addDivertimento($divertimento){
        $this->divertimento+=$divertimento;
        $this->divertimento=$this->check($this->divertimento);
    }
    public function addEnergia($energia){
        $this->energia+=$energia;
        $this->energia=$this->check($this->energia);
    }

    public function __construct($nome, $fame, $divertimento, $energia, $vita) {
        $this->nomeAnimaletto = $nome;
        $this->fame = $fame;
        $this->divertimento = $divertimento;
        $this->energia = $energia;
        $this->vita = $vita;
    }
    abstract public function mangia();
    abstract public function accarezza();
    abstract public function dormi();

    // Funzione per calcolare la vita dell'animale in base ai valori di energia, fame e divertimento
    function calcolaVita() {
    // Calcola la vita come la media aritmetica dei valori di energia, fame e divertimento
    $this->lastUpdate=new DateTime();
    $this->vita = round(($this->energia + $this->fame + $this->divertimento) / 3);
}
     public function decrease(){
        $this->fame-=$this->fame_decreaser;
        $this->divertimento-=$this->divertimento_decreaser;
        $this->energia-=$this->energia_decreaser;
        $this->energia=$this->check($this->energia);
        $this->divertimento=$this->check($this->divertimento);
        $this->fame=$this->check($this->fame);
    }
    protected function check($value){
        if($value>=100){
            return $value=100;
        }elseif($value<=0){
            return $value=0;
        }
        return $value;
    }

    public function offlineDecrease(DateTime $timeAfterOffline){
        $this->lastUpdate=new DateTime();
        $timeSpan = $timeAfterOffline->diff($this->lastUpdate);
        $statsDegrees = (int)($timeSpan->format('%f') * 2);
        
        $this->fame -= $statsDegrees;
        $this->divertimento -= $statsDegrees;
        $this->energia -= $statsDegrees;
        
        $this->fame = $this->check($this->fame);
        $this->divertimento = $this->check($this->divertimento);
        $this->energia = $this->check($this->energia);

    }
}




?>