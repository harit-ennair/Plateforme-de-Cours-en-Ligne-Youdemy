<?php


abstract class test 
{

protected $test1;
protected $test2;
protected $test3;

abstract public function metod1();
abstract public function metod2();

}



class meto1 extends test 
{


public function metod1(){
    return"exompel1 metod 1";
    
}
public function metod2(){
    
    return"exompel1 metod 2";
}

}
class meto2 extends test 
{
    
    
    public function metod1(){
        return"exompel2 metod 1";
        
    }
    public function metod2(){
        
        return"exompel2 metod 2";
}

}


$allmethods = [];
$one= new meto1;
$two= new meto2;
$allmethods[] =$one;
$allmethods[] =$two;

foreach ($allmethods as $meto) {
    echo $meto->metod1();
    echo '<br />';
    echo $meto->metod2();
    echo '<br />';
}

