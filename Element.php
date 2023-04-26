<?php
class Element {
    const EAU = 'eau';
    const FEU = 'feu';
    const PLANTE = 'plante';

    private string $type;

    public function __construct(string $type) {
        $this->type = $type;
    }

    public function getType(): string {
        return $this->type;
    }

    public function __toString(): string {
        return $this->getType();
    }
}
?>