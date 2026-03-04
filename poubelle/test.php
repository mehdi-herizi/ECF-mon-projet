<?php 
class Animaux {
      protected $protectedAttribute = "Accessible dans ParentClass et classes enfants";

      protected function animaux() {
          return "je suis un etre vivant";
      }
  }

  class Mamifere extends Animaux {
      
  protected function mamifere(){
    return "je suis un mamifere";

    
  }
  }
  class Baleine extends Mamifere {
        public function baleine(){
            return $this->protectedAttribute . " et " . $this->animaux() . " et " . $this->mamifere();
        }
    }

  $childObj = new Baleine();
  echo $childObj->baleine(); // Affiche la valeur et le résultat de la méthode protégée

?>