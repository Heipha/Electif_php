<?php 

class User
{
    public string $name;
    public string $firstName;
    public string $email;
    private int $age;

    public function __construct(string $name, string $firstName, string $email, int $age)
    {
        $this->name = $name;
        $this->firstName = $firstName;
        $this->email = $email;
        $this->age = $age;

    }

    public function getAge(): int
    {
        return "{$this->age} ans";
    }

    public function setAge(int $age): void
    {
        if($age < 0){
            throw new Exception("L'âge ne peut être négatif 0");
        }
        $this->age = $age;
    }
}


/*
class User
{
    public function __construct(
        public string $name,
        public string $firstName,
        public string $email,
        public int $age
        )
   {}
}
*/