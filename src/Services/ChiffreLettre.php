<?php
namespace App\Services;

class ChiffreLettre
{
    public function convert($a)
        {
        $convert = explode('.',$a);
        if (isset($convert[1]) && $convert[1]!=''){
        return $this->convert($convert[0]).'Dinars'.' et '.$this->convert($convert[1]).'Centimes' ;
        }
        if ($a<0) return 'moins '.$this->convert(-$a);
        if ($a<17){
        switch ($a){
        case 0: return 'zero';
        case 1: return 'un';
        case 2: return 'deux';
        case 3: return 'trois';
        case 4: return 'quatre';
        case 5: return 'cinq';
        case 6: return 'six';
        case 7: return 'sept';
        case 8: return 'huit';
        case 9: return 'neuf';
        case 10: return 'dix';
        case 11: return 'onze';
        case 12: return 'douze';
        case 13: return 'treize';
        case 14: return 'quatorze';
        case 15: return 'quinze';
        case 16: return 'seize';
        }
        } else if ($a<20){
        return 'dix-'.$this->convert($a-10);
        } else if ($a<100){
        if ($a%10==0){
        switch ($a){
        case 20: return 'vingt';
        case 30: return 'trente';
        case 40: return 'quarante';
        case 50: return 'cinquante';
        case 60: return 'soixante';
        case 70: return 'soixante-dix';
        case 80: return 'quatre-vingt';
        case 90: return 'quatre-vingt-dix';
        }
        } elseif (substr($a, -1)==1){
        if( ((int)($a/10)*10)<70 ){
        return $this->convert((int)($a/10)*10).'-et-un';
        } elseif ($a==71) {
        return 'soixante-et-onze';
        } elseif ($a==81) {
        return 'quatre-vingt-un';
        } elseif ($a==91) {
        return 'quatre-vingt-onze';
        }
        } elseif ($a<70){
        return $this->convert($a-$a%10).'-'.$this->convert($a%10);
        } elseif ($a<80){
        return $this->convert(60).'-'.$this->convert($a%20);
        } else{
        return $this->convert(80).'-'.$this->convert($a%20);
        }
        } else if ($a==100){
        return 'cent';
        } else if ($a<200){
        return $this->convert(100).' '.$this->convert($a%100);
        } else if ($a<1000){
        return $this->convert((int)($a/100)).' '.$this->convert(100).' '.$this->convert($a%100);
        } else if ($a==1000){
        return 'mille';
        } else if ($a<2000){
        return $this->convert(1000).' '.$this->convert($a%1000).' ';
        } else if ($a<1000000){
        return $this->convert((int)($a/1000)).' '.$this->convert(1000).' '.$this->convert($a%1000);
        }
        else if ($a==1000000){
        return 'millions';
        }
        else if ($a<2000000){
        return $this->convert(1000000).' '.$this->convert($a%1000000).' ';
        }
        else if ($a<1000000000){
        return $this->convert((int)($a/1000000)).' '.$this->convert(1000000).' '.$this->convert($a%1000000);
        }
    }    
}

